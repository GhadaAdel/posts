<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\TokenService;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\RefreshTokenRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;

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

    public function login(LoginRequest $request, TokenService $tokenService)
    {
        $user = $request->login();

        if ($user) {
            return response([
                'user' => new UserResource($user),
                'access_token' => $user->createToken('auth_token')->plainTextToken,
                'refresh_token' => $tokenService->createRefreshToken($user),
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

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $token = $request->sendResetLink();

        return response([
            'message' => 'Password reset token generated.',
            'token' => $token
        ], 200);
    }
    
    public function resetPassword(ResetPasswordRequest $request)
    {
        $status = $request->resetPassword();

        if ($status === Password::PASSWORD_RESET) {
            return response([
                'message' => __($status)
            ], 200);
        }

        return response([
            'message' => __($status)
        ], 400);
    }

    public function refresh(RefreshTokenRequest $request)
    {
        $data = $request->refresh();

        return response([
            ...$data,
            'message' => 'Access token refreshed successfully.'
        ]);
    }
}
