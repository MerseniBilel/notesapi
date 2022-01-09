<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class UserController extends Controller
{


    public function exist(String $email)  {
        $user = User::where('email', $email)->first();
        if($user){
            return true;
        }else {
            return false;
        }
    }

    
    public function register(Request $request) : Response{
        
        $fields = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string|confirmed|min:6',
        ]);

        $exist = $this->exist($fields['email']);

        if($exist){
            return response([
                'error' => 'User already exist'
            ], 409);
        }

        $user = User::create([
            'name' => $fields['name'],
            'username' => $fields['username'],
            'password' => bcrypt($fields['password']),
            'email' => $fields['email'],
        ]);

        $token = $user->createToken('registerToken')->plainTextToken;
        
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
}
