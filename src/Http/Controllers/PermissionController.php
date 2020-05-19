<?php

namespace Laralife\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laralife\Auth\Http\Resources\PermissionCollection;
use Laralife\Auth\Http\Resources\PermissionResource;
use Laralife\Auth\Models\Permission;
use Illuminate\Support\Facades\Route as RouteFacade;
class PermissionController extends Controller
{

    public function index()
    {

        $limit = request()->has('limit') ? request()->get('limit') : null;
        return new PermissionCollection(Permission::paginate($limit));
    }

    public function store(Request $request)
    {
        return new PermissionResource(Permission::create($request->all()));
    }

    public function show(Permission $permission)
    {

        return new PermissionResource($permission);
    }

    public function update(Request $request, Permission $permission)
    {
        $permission->update($request->all());

        return new PermissionResource($permission);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json(null, 204);
    }
}
