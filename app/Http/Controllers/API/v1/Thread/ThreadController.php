<?php

namespace App\Http\Controllers\API\v1\Thread;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Channel\CreateChannelRequest;
use App\Http\Requests\API\v1\Thread\CreateThreadRequest;
use App\Http\Requests\API\v1\Thread\UpdateThreadRequest;
use App\Models\Thread;
use App\Repositories\ThreadRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

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
        $this->threadRepo->update($request->id, $request->title, $request->body);
        return response()->json([
            'message' => 'thread updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


}
