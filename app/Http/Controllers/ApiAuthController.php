<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required|min:3",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:8",
            "confirm_password" => "required|same:password",
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json(["message" => "created successfully"], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            "email" => "required",
            "password" => "required"
        ]);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                "message" => "Login Failed", "error" => "Wrong Credentials"
            ], 422);
        };
        $token = auth()->user()->createToken("user-auth");
        return response()->json(["message" => "login success", "auth-token" => $token->plainTextToken]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json(["message" => "logout successfully"]);
    }
}
