<?php

namespace App\Http\Requests;

use App\Models\RefreshToken;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class RefreshTokenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'refresh_token' => 'required|string',
        ];
    }

    public function refresh()
    {
        $tokenValue = $this->input('refresh_token');

        $hashedToken = hash('sha256', $tokenValue);

        $refreshToken = RefreshToken::where('token', $hashedToken)->first();

        if (!$refreshToken || $refreshToken->isExpired()) {
            throw ValidationException::withMessages([
                'refresh_token' => ['Invalid or expired refresh token.']
            ]);
        }

        $user = $refreshToken->user;

        $user->tokens()->where('name', 'access_token')->delete();

        $newAccessToken = $user->createToken('access_token')->plainTextToken;
        
        return $newAccessToken;
    }
}
