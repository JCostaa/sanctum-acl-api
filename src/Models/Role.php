<?php

namespace Laralife\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Arr;
use Laralife\Auth\Traits\HasPermissions;
use Laralife\Auth\Traits\HasRoles;

class Role extends Model
{

    use HasRoles,HasPermissions;
    protected $guarded = ['id'];

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

}
