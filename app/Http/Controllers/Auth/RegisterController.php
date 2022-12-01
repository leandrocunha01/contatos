<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request){
        $userData = $request->only('name', 'email', 'password');
        $request->validate(['email' => 'required|email|unique:users', 'password' => 'required']);
        $userData['password'] = bcrypt($request->password);

        return User::create($userData);
    }
}
