<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show(User $user)
    {
        return $user->posts()->paginate();
    }
}
