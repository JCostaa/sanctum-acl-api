<?php

namespace Laralife\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $token = auth()->user()->createToken('here-token-name');

        return $this->respondWithToken($token->plainTextToken);
    }

    public function logout()
    {
        auth('sanctum')->user()->tokens()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }
    /**
     * @param  string  $token
     * @return JsonResponse
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
    }


}
