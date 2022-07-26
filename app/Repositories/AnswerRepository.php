<?php


namespace App\Repositories;


use App\Interfaces\AnswerRepoInterface;
use App\Models\Answer;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AnswerRepository implements AnswerRepoInterface
{
    private \Illuminate\Database\Eloquent\Builder $model;

    public function __construct()
    {
        $this->model = Answer::query();
    }

    public function index(): Collection
    {
        return $this->model->latest()->get();
    }

    public function create($body , $thread_id): Model
    {
        return Thread::find($thread_id)->answers()->create([
            'body' => $body,
            'user_id' => auth()->user()->id,
        ]);
    }

}
