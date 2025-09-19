<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user){
        
        return inertia('Profile/show', [
            'user' => $user,
            'already_followed' => auth()->user()->alreadyFollowed($user)
        ]);
    }
}
