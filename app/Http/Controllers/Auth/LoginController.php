<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request){
        $credentials = $request->only('email', 'password');

        $request->validate(['email' => 'required|email', 'password' => 'required']);

        if(!auth()->attempt($credentials)) return ['success' => false, 'response' =>  'Invalid credentials'];;

        $token = auth()->user()->createToken('authToken');

        return ['data' => ['token' => $token]];
    }

    public function logout(){
        return auth()->user()->currentAccessToken()->delete();
    }
}
