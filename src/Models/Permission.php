<?php

namespace Laralife\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laralife\Auth\Traits\HasRoles;

class Permission extends Model
{
    use HasRoles;
    protected $guarded = ['id'];

}
