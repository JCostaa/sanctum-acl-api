<?php

use Illuminate\Http\Request;


use App\User;
use Illuminate\Support\Facades\Hash;



Route::post('login', 'AuthController@login');


Route::group(['middleware' => ['auth:sanctum','has.acl']], function () {

    Route::apiResource('roles', 'RoleController');

    Route::apiResource('users', 'UserController');

    Route::apiResource('permissions', 'PermissionController');

    Route::post('logout', 'AuthController@logout');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
