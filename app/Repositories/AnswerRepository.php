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
        return $this->model->create([
            'body' => $body,
            'thread_id'=>Thread::query()->find($thread_id)->isRelation('answers'),
            'user_id' => auth()->id(),
        ]);
    }

    public function update($body): int
    {
        return $this->model->update([
           'body'=>$body,
        ]);
    }

    public function destroy($id): bool
    {
        return $this->model->find($id)->delete();
    }

    public function user($user_id): Model
    {
        return $this->model->find($user_id);
    }

}
