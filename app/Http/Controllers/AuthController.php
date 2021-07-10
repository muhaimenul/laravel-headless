<?php

namespace App\Http\Controllers;

use App\Http\Services\UserService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $userSvc;

    public function __construct(UserService $userSvc)
    {
        $this->userSvc = $userSvc;
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = $this->userSvc->createUser($validatedData);

//        TODO:: send Email for confirmation

        $token = $this->userSvc->createToken($user);

        return response()->json([
            'status' => true,
            'message' => 'Register successfully!',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
