<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $req)
    {
        $validationRegis = $req->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $validationRegis['password'] = Hash::make($req->password);

        $user = User::create($validationRegis);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['data' => $user, 'access_token' => $accessToken], 201);
    }

    public function login(Request $req)
    {
        $validationLogin = $req->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(!auth()->attempt($validationLogin)){
            return response(['message' => 'User tidak terdaftar'],400);
        }
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return response(['data' => auth()->user(), 'access_token' => $accessToken]);
    }
}
