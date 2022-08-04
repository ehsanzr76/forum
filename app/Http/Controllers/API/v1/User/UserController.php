<?php

namespace App\Http\Controllers\API\v1\User;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepo;

    public function __construct(UserRepository $repo)
    {
        $this->userRepo = $repo;
    }

    public function index()
    {
        $this->userRepo->index();
        return response()->json([
            $this->userRepo
        ], Response::HTTP_OK);
    }

}
