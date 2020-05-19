<?php

namespace Laralife\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laralife\Auth\Http\Resources\UserCollection;
use Laralife\Auth\Http\Resources\UserResource;
use Laralife\Auth\Models\Role;
use Laralife\Auth\Models\User;

class UserController extends Controller
{

    public function index()
    {
        $limit = request()->has('limit') ? request()->get('limit') : null;
        return new UserCollection(User::paginate($limit));
    }

    public function store(Request $request)
    {
            return new UserResource(User::create($request->all()));
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());

        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }
}
