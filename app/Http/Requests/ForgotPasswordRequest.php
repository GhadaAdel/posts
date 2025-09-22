<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
        ];
    }

    public function sendResetLink()
    {
        $user = User::where('email', $this->email)->first();

        if (!$user) {
            return response([
                'message' => 'User not found.'
            ], 404);
        }

        return Password::broker()->createToken($user);
    }
}
