<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(Request $request)
    {
        if(auth()->attempt($request->only(['email', 'password'])))
        {
            $token = auth()->user()->createToken('tokens');
            return response()->json([
                'status' => true,
                'message' => 'Login Successfully',
                'user' => auth()->user(),
                'access_token' => $token->plainTextToken,
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Invalid Credentials',
            ]);
        }
    }
}
