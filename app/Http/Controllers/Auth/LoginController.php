<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Mockery\Generator\StringManipulation\Pass\Pass;


class LoginController extends Controller
{
    public function login(Request $request){
        $credentials = $request->only('email', 'password');

        $request->validate(['email' => 'required|email', 'password' => 'required']);

        if(!auth()->attempt($credentials)) return ['success' => false, 'response' =>  'Invalid credentials'];

        $token = auth()->user()->createToken('authToken');

        return ['data' => ['token' => $token]];
    }

    public function logout(){
        return auth()->user()->currentAccessToken()->delete();
    }

    public function resetPassword(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users',
            'type'  => 'required|in:sms,email'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user){

        }

        if($request->type == 'email'){
            $token = Password::createToken($user);
            Password::sendResetLink(['email' => $user, 'token' => $token]);
        }else{
            $token = str_pad(rand(0, 90000), 4, 0);
            // implementar uma api de sms
        }

        return ['success' => false, 'response' =>  'Mensagem enviada'];
    }
}
