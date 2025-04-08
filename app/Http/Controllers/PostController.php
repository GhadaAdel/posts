<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::paginate();
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request)
    {
        $post = $request->storePost();

        return response([
            'message' => 'This post is stored successfully!',
            'post' => PostResource::make($post)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response([
            'message' => 'Information of this post',
            'post' => PostResource::make($post)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        $request->updatePost();

        return response([
            'message' => 'This post is updated successfully!',
            'post' => PostResource::make($post)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response([
            'message' => 'This post is deleted successfully!'
        ]);
    }
}