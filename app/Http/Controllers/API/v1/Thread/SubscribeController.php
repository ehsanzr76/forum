<?php

namespace App\Http\Controllers\API\v1\Thread;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Subscribe\SubscribeRequest;
use App\Http\Requests\API\v1\Subscribe\UnSubscribeRequest;
use App\Repositories\SubscribeRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SubscribeController extends Controller
{
    /**
     * @var SubscribeRepository
     */
    private SubscribeRepository $subscribeRepo;

    public function __construct(SubscribeRepository $repo)
    {
        $this->subscribeRepo = $repo;
        $this->middleware(['user-block']);
    }


    public function store(SubscribeRequest $request): JsonResponse
    {
        $request->safe()->all();
        $this->subscribeRepo->store($request->input('thread_id'));
        return response()->json([
           'message'=>'user subscribed successfully'
        ], Response::HTTP_CREATED);
    }

    public function destroy(UnSubscribeRequest $request): JsonResponse
    {
        $request->safe()->all();
        $this->subscribeRepo->destroy($request->id , $request->thread_id);
       return response()->json([
           'message'=>'user unsubscribed successfully'
       ] , Response::HTTP_OK);

    }
}
