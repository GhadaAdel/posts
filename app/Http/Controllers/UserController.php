<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response([
            'message' => 'Information of this user',
            'user' => UserResource::make($user)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $request->updateUser();

        return response([
            'message' => 'This user is updated successfully!',
            'user' => UserResource::make($user)
        ]);
    }
}