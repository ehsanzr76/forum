<?php

namespace App\Http\Controllers\API\v1\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class NotificationController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            auth()->user()->unreadNotifications(),
        ] , Response::HTTP_OK);
    }
}
