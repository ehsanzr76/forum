<?php

namespace App\Http\Middleware;

use App\Repositories\UserRepository;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use \Symfony\Component\HttpFoundation\Response;

class UserBlock
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepo;

    public function __construct(UserRepository $repo)
    {
        $this->userRepo = $repo;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return JsonResponse
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        if (!$this->userRepo->userBlock()) {
            return $next($request);
        }
        return response()->json([
            'message' => 'you are blocked'
        ], Response::HTTP_FORBIDDEN);
    }
}
