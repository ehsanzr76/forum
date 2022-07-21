<?php

namespace App\Http\Controllers\Api\V01\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required', 'email', 'unique:users',
            'password' => 'required'
        ]);
       resolve(UserRepository::class)->create($request);

        return response()->json([
            'message' => 'user create successfully'
        ], Response::HTTP_CREATED);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required', 'email', 'unique:users',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only(['email', 'password']))) {
            return response()->json(Auth::User(), 200);
        }

        throw ValidationException::withMessages([
            'email' => 'incorrect credentials'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'logged out successfully'
        ], Response::HTTP_OK);
    }


    public function user()
    {
        return response()->json(Auth::User() , Response::HTTP_OK);
    }


}
