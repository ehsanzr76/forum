<?php

namespace App\Http\Controllers\API\v1\Thread;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Answer\CreateAnswerRequest;
use App\Http\Requests\API\v1\Answer\DestroyAnswerRequest;
use App\Http\Requests\API\v1\Answer\UpdateAnswerRequest;
use App\Models\Subscribe;
use App\Models\Thread;
use App\Notifications\NewReplySubmitted;
use App\Repositories\AnswerRepository;
use App\Repositories\SubscribeRepository;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;

class AnswerController extends Controller
{
    /**
     * @var AnswerRepository
     */
    private AnswerRepository $answerRepo;
    /**
     * @var SubscribeRepository
     */
    private SubscribeRepository $subscribeRepo;

    public function __construct(AnswerRepository $repo , SubscribeRepository $repository)
    {
        $this->answerRepo = $repo;
        $this->subscribeRepo = $repository;
    }

    public function index(): JsonResponse
    {
        $this->answerRepo->index();
        return response()->json($this->answerRepo, Response::HTTP_OK);
    }

    public function store(CreateAnswerRequest $request , NotificationService $service): JsonResponse
    {
        $request->safe()->all();
        $this->answerRepo->create($request->body, $request->thread_id);
        Notification::send(
            $service->getUserInstance($request->thread_id),
            $service->notifyUserForNewReply($request->thread_id)
        );
        return response()->json([
            'message' => 'answer created successfully'
        ], Response::HTTP_CREATED);
    }


    public function update(UpdateAnswerRequest $request): JsonResponse
    {
        $request->safe()->all();
        if (Gate::forUser(auth()->user())->allows('update&delete-answer-user', $this->answerRepo->user($request->id))) {
            $this->answerRepo->update($request->input('body'));
            return response()->json([
                'message' => 'answer updated successfully'
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'access denied',
        ], Response::HTTP_FORBIDDEN);

    }

    public function destroy(DestroyAnswerRequest $request): JsonResponse
    {
        $request->safe()->all();
        if (Gate::forUser(auth()->user())->allows('update&delete-answer-user', $this->answerRepo->user($request->id))) {
            $this->answerRepo->destroy($request->input('id'));
            return response()->json([
                'message' => 'answer deleted successfully'
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'access denied',
        ], Response::HTTP_FORBIDDEN);

    }
}
