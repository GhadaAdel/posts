<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class PostUpdateRequest extends FormRequest
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
            'title' => 'sometimes|string|min:3|max:255',
            'content' => 'sometimes|string|min:10|max:255',
            'user_id' => 'sometimes|integer|exists:users,id'
        ];
    }

    public function updatePost()
    {
        return DB::transaction( function() {
            $this->post->update([
                'title' => $this->input('title'),
                'content' => $this->input('content'),
                'user_id' => $this->input('user_id')
            ]);

            return $this->post;
        });
    }
}
