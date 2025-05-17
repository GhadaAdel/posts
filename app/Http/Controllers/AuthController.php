<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = $request->register();

        if ($user) {
            return response([
                'user' => new UserResource($user),
                'token' => $user->createToken('auth_token')->plainTextToken,
                'message' => 'You are registered successfully!',
            ]);
        }
    }

    public function login(LoginRequest $request)
    {
        $user = $request->login();

        if ($user) {
            return response([
                'user' => new UserResource($user),
                'token' => $user->createToken('auth_token')->plainTextToken,
                'message' => 'You are logged in successfully!'
            ]);
        }

        return response([
                'message' => 'The provided credentials are incorrect!'
        ], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response([
            'message' => 'You are logged out successfully!'
        ]);
    }
}
