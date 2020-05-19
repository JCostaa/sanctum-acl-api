<?php

namespace Laralife\Auth\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Laralife\Auth\Models\Permission;
use Laralife\Auth\Services\AbilitiesService;
use PhpParser\Node\Expr\Cast\Bool_;

class AuthServiceProvider extends ServiceProvider
{
    private const ROOT_PATH = __DIR__ . '/../..';

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadMigrationsFrom(self::ROOT_PATH . '/database/migrations');
        $this->loadFactoriesFrom(self::ROOT_PATH . '/database/factories');
        $this->registerPermissions();
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Check for database connection.
     * @return bool
     */
    private function checkConnectionStatus(): bool
    {
        try {
            DB::connection()->getPdo();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }


    protected function registerPermissions()
    {
        try {
            if ($this->checkConnectionStatus()) {
                if (Schema::hasTable('permissions')) {
                    Permission::all()->map(function ($permission) {
                        Gate::define($permission->verb . '|' . $permission->uri, function ($user) use ($permission) {
                            dd($user->existPermission($permission));
                        });
                    });
                }
            }
        } catch (\Exception $e) {
            return;
        }
    }
    protected function bootForConsole()
    {
    
        $permissionSeederPath = 'seeds/PermissionsTableSeeder.php';
        $this->publishes([
            self::ROOT_PATH . '/database/' . $permissionSeederPath => database_path($permissionSeederPath),
        ], 'auth-seeds');
    }
}
