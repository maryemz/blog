<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use JWTAuth;
use App\User;
use Auth;

class LoginController extends Controller
{
   
   public function login(Request $request)
{
    $credentials = $request->only('email', 'password');
    if ( ! $token = JWTAuth::attempt($credentials)) {
            return response([
                'status' => 'error',
                'error' => 'invalid.credentials',
                'msg' => 'Invalid Credentials.'
            ], 400);
    }
    return response([
            'status' => 'success',
            'user'  => Auth::user()->id
        ])
        ->header('Authorization', $token);
}
public function user(Request $request)
{
    $user = Auth::user()->id;
    return response([
            'status' => 'success',
            'data' => $user
        ]);
}
public function refresh()
{
    return response([
            'status' => 'success'
        ]);
}
public function logout()
{
    JWTAuth::invalidate();
    return response([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
}
}
