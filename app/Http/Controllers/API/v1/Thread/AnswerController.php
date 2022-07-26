<?php

namespace App\Http\Controllers\API\v1\Thread;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Repositories\AnswerRepository;
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

    public function index()
    {
        $this->answerRepo->index();
        return response()->json($this->answerRepo , Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        //
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
