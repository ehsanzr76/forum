<?php

namespace App\Http\Controllers\API\v1\Thread;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Thread\CreateThreadRequest;
use App\Http\Requests\API\v1\Thread\DestroyThreadRequest;
use App\Http\Requests\API\v1\Thread\UpdateThreadRequest;
use App\Repositories\ThreadRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class ThreadController extends Controller
{

    /**
     * @var ThreadRepository
     */
    private ThreadRepository $threadRepo;

    public function __construct(ThreadRepository $repo)
    {
        $this->threadRepo = $repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $this->threadRepo->index();
        return response()->json($this->threadRepo, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $slug
     * @return JsonResponse
     */
    public function show($slug): JsonResponse
    {
        $this->threadRepo->show($slug);
        return response()->json($this->threadRepo, Response::HTTP_OK);
    }


    public function store(CreateThreadRequest $request): JsonResponse
    {
        $request->safe()->all();
        $this->threadRepo->create($request->title, $request->body);
        return response()->json([
            'message' => 'thread created created successfully',
        ], Response::HTTP_CREATED);
    }


    public function update(UpdateThreadRequest $request): JsonResponse
    {
        $request->safe()->all();
        if (Gate::forUser(auth()->user())->allows('update&delete-thread-user', $this->threadRepo->user($request->user_id))) {
            $this->threadRepo->update($request->id, $request->title, $request->body, $request->best_answer_id);
            return response()->json([
                'message' => 'thread updated successfully',
            ], Response::HTTP_OK);
        }
        return response()->json([
            'message' => 'access denied',
        ], Response::HTTP_FORBIDDEN);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyThreadRequest $request
     * @return JsonResponse
     */
    public function destroy(DestroyThreadRequest $request): JsonResponse
    {
        $request->safe()->all();
        if (Gate::forUser(auth()->user())->allows('update&delete-thread-user', $this->threadRepo->user($request->user_id))) {
            $this->threadRepo->destroy($request->id);
            return response()->json([
                'message' => 'thread deleted successfully'
            ], Response::HTTP_OK);
        }
        return response()->json([
            'message' => 'access denied',
        ], Response::HTTP_FORBIDDEN);
    }


}
