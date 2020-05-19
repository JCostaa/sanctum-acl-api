<?php

namespace Laralife\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laralife\Auth\Http\Resources\RoleCollection;
use Laralife\Auth\Http\Resources\RoleResource;
use Laralife\Auth\Models\Role;

class RoleController extends Controller
{

    public function index()
    {
        $limit = request()->has('limit') ? request()->get('limit') : null;
       return new RoleCollection(Role::paginate($limit));
    }

    public function store(Request $request)
    {
            return new RoleResource(Role::create($request->all()));
    }

    public function show(Role $role)
    {
        return new RoleResource($role);
    }

    public function update(Request $request, Role $role)
    {
        $role->update($request->all());

        return new RoleResource($role);
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json(null, 204);
    }
}
