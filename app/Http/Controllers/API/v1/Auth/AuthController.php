<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Auth\LoginAuthRequest;
use App\Http\Requests\API\v1\Auth\RegisterAuthRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{


    /**
     * @var UserRepository
     */
    private UserRepository $userRepo;

    public function __construct(UserRepository $repo)
    {
        $this->userRepo = $repo;
    }

    public function register(RegisterAuthRequest $request)
    {
        $request->safe()->all();
        $this->userRepo->create($request->name , $request->email , $request->password);

        return response()->json([
            'message' => 'user create successfully'
        ], Response::HTTP_CREATED);
    }


    public function login(LoginAuthRequest $request)
    {
        $request->safe()->all();
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
        return response()->json(Auth::User(), Response::HTTP_OK);
    }


}
