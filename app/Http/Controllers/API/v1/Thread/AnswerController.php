<?php

namespace App\Http\Controllers\API\v1\Thread;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Answer\CreateAnswerRequest;
use App\Repositories\AnswerRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
