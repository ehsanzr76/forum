<?php


namespace App\Repositories;


use App\Interfaces\SubscribeRepoInterface;
use App\Models\Subscribe;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Model;

class SubscribeRepository implements SubscribeRepoInterface
{
    private \Illuminate\Database\Eloquent\Builder $model;

    public function __construct()
    {
        $this->model = Subscribe::query();
    }

    public function store($thread_id): Model
    {
        return $this->model->create([
           'thread_id'=>Thread::query()->find($thread_id)->isRelation('subscribes'),
            'user_id'=>auth()->id()
        ]);
    }

    public function destroy($id , $thread_id): bool
    {
        return $this->model->find($id)->Where([
            ['thread_id' , $thread_id],
            ['user_id' , auth()->id()]
        ])->delete();
    }
}
