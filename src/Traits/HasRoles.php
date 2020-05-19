<?php

namespace Laralife\Auth\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laralife\Auth\Models\Permission;
use Laralife\Auth\Models\Role;

trait HasRoles
{

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    /**
     * @param  Role $role
     * @return bool
     */
    public function hasRole(Role $role): bool
    {
        return $this->roles->contains($role);
    }


    /**
     * @param array $attributes
     * @return Builder|Model
     */
    public static function create(array $attributes = [])
    {
        $roles = $attributes['roles'] ?? null;

        if ($roles) {
            unset($attributes['roles']);
        }

        $model = static::query()->create($attributes);

        if ($roles) {

            $model->roles()->attach($roles);
        }

        return $model;
    }

    /**
     * @param array $attributes
     * @param array $options
     * @return bool
     */
    public function update(array $attributes = [], array $options = [])
    {
        $roles = $attributes['roles'] ?? null;
        if ($roles) {
            unset($attributes['roles']);
        }

        $updated = parent::update($attributes, $options);

        if ($updated && $roles) {
            $this->roles()->sync($roles);
        }

        return $updated;
    }
}
