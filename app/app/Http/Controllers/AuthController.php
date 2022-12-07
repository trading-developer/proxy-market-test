<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    /**
     * @param Request $request
     * @return JSON
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * @param Request $request
     * @return JSON
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);

        return response()->json([
            'status' => 'success',
            'message' => 'Успешная регистрация',
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * @return JSON
     */
    public function logout()
    {
        Auth::logout();

        return response()->json([
            'status' => 'success',
            'message' => 'Success',
        ]);
    }

    /**
     * @return JSON
     */
    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'token' => Auth::refresh(),
        ]);
    }
}
