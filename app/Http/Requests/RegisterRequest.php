<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:20',
            'email' => 'required|email|unique:users|max:50',
            'password' => 'required|string|min:8',
        ];
    }

    public function register()
    {
        return DB::transaction(function () {
            $user = User::create([
                'name' => $this->input('name'),
                'email' => $this->input('email'),
                'password' => bcrypt($this->input('password')),
            ]);
            
           return $user;
        });
    }
}
