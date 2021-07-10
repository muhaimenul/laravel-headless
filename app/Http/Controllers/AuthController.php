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
            'password' => 'required|string|min:8|confirmed',
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

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if (!auth()->attempt($validatedData)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = $this->userSvc->model->where('email', $validatedData['email'])->firstOrFail();

        $token = $this->userSvc->createToken($user);

        return response()->json([
            'status' => true,
            'message' => 'Logged in successfully!',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function profile()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();


        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully!',
        ]);
    }
}
