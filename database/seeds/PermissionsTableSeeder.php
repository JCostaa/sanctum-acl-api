<?php

use Laralife\Auth\Models\Permission;
use Laralife\Auth\Models\Role;
use Laralife\Auth\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route as RouteFacade;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = $this->getAdminRole();
        $this->createPermissions($role);

        $user = $this->getUserAdmin();
        $this->addRole($role, $user);
    }

    /**
     * @return Role
     */
    protected function getAdminRole(): Role
    {
        return Role::find(1)
            ? Role::find(1)
            : Role::create(['name' => 'Admin', 'description' => 'All privileges']);
    }

    /**
     * @param Role $role
     */
    protected function createPermissions(Role $role): void
    {
        foreach (RouteFacade::getRoutes() as $route) {
            if ($this->shouldIgnore($route)) {
                continue;
            }

            $permission = $this->persistPermission($route);

            $role->permissions()->attach($permission);
        }
    }

    /**
     * @return User
     */
    protected function getUserAdmin(): User
    {
        return User::find(1)
            ? User::find(1)
            : User::create(['name' => 'Admin', 'email' => 'admin@laralife.com']);
    }

    /**
     * @param Role $role
     * @param User $user
     */
    protected function addRole(Role $role, User $user): void
    {
        if (! $user->roles->contains($role)) {
            $user->roles()->attach($role);
        }
    }

    /**
     * @param Route $route
     * @return bool
     */
    private function shouldIgnore(Route $route): bool
    {
        return (
            ! in_array('has.acl', $route->gatherMiddleware()) ||
            ! $route->uri ||
            ! Permission::whereIn('verb', $route->methods)->where('uri', $route->uri)
        );
    }

    /**
     * @param $route
     * @return array
     */
    private function persistPermission($route)
    {
        $permission = [];
        foreach ($route->methods as $method) {
            if (in_array($method, ['HEAD', 'PATCH'])) {
                continue;
            }

            $permission = Permission::create([
                'verb' => $method,
                'uri' => $route->uri,
            ]);
        }

        return $permission;
    }
}
