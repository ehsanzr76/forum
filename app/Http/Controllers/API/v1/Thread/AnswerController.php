<?php

namespace App\Http\Controllers\API\v1\Thread;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Answer\CreateAnswerRequest;
use App\Http\Requests\API\v1\Answer\DestroyAnswerRequest;
use App\Http\Requests\API\v1\Answer\UpdateAnswerRequest;
use App\Repositories\AnswerRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class AnswerController extends Controller
{
    /**
     * @var AnswerRepository
     */
    private AnswerRepository $answerRepo;

    public function __construct(AnswerRepository $repo)
    {
        $this->answerRepo = $repo;
    }

    public function index(): JsonResponse
    {
        $this->answerRepo->index();
        return response()->json($this->answerRepo, Response::HTTP_OK);
    }

    public function store(CreateAnswerRequest $request): JsonResponse
    {
        $request->safe()->all();
        $this->answerRepo->create($request->body , $request->thread_id);
        return response()->json([
            'message' => 'answer created successfully'
        ], Response::HTTP_CREATED);
    }


    public function show($id)
    {
        //
    }


    public function update(UpdateAnswerRequest $request): JsonResponse
    {
        $request->safe()->all();
        if (Gate::forUser(auth()->user())->allows('update&delete-answer-user', $this->answerRepo->user($request->user_id))){
            $this->answerRepo->update($request->body);
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
        if (Gate::forUser(auth()->user())->allows('update&delete-answer-user', $this->answerRepo->user($request->user_id))){
            $this->answerRepo->destroy($request->id);
            return \response()->json([
                'message'=>'answer deleted successfully'
            ] , Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'access denied',
        ], Response::HTTP_FORBIDDEN);

    }
}
