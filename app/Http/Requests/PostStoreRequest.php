<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class PostStoreRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:10|max:255',
            'user_id' => 'required|integer|exists:users,id'
        ];
    }

    public function storePost()
    {
        return DB::transaction( function() {
            $post = Post::create([
                'title' => $this->input('title'),
                'content' => $this->input('content'),
                'user_id' => $this->input('user_id')
            ]);

            return $post;
        });
    }
}
