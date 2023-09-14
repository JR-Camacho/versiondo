<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function getAuthUser()
    {
        return auth()->user();
    }

    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->all();
            $data['password'] = Hash::make($request->password);
            User::create($data);

            return response()->json([
                "status" => 1,
                "msg" => 'Successful registration'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 0,
                "msg" => 'Registration Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function login(LoginRequest $request)
    {
        if (User::where("email", $request->email)->first()) $user = User::where("email", $request->email)->first();

        if (isset($user->id)) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken("auth_token")->plainTextToken;

                return response()->json([
                    "status" => 1,
                    "msg" => 'Successful Authentication',
                    "access_token" => $token,
                    "user" => $user
                ]);
            } else {
                return response()->json([
                    "status" => 0,
                    "msg" => 'Authentication Error'
                ], 404);
            }
        } else {
            return response()->json([
                "status" => 0,
                "msg" => "User does not exist"
            ], 404);
        }
    }

    public function logout()
    {
        if (auth()->check()) {
            auth()->user()->tokens()->delete();

            return response()->json([
                "status" => 1,
                "msg" => "Logout"
            ]);
        } else {
            return response()->json([
                "status" => 0,
                "msg" => "User is not authenticated"
            ], 401);
        }
    }
}
