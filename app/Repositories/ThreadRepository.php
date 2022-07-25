<?php


namespace App\Repositories;


use App\Interfaces\ThreadRepoInterface;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ThreadRepository implements ThreadRepoInterface
{
    private Builder $model;

    public function __construct()
    {
        $this->model = Thread::query();

    }

    public function index(): Collection
    {
        $threads = $this->model->where('flag', 1)->latest()->get();
        return $threads;
    }


    public function show($slug): Model
    {
        $thread = $this->model->where('slug', $slug)->where('flag', 1)->first();
        return $thread;
    }


    public function create($title, $body): Model
    {
        return $this->model->create([
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => $body,
            'channel_id' => Thread::factory()->create()->id,
            'user_id' => auth()->user()->id,
        ]);
    }


    public function update($id, $title, $body, $best_answer_id = null): bool
    {
        return $this->model->update([
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => $body,
            'channel_id' => Thread::factory()->create()->id,
            'best_answer_id' => $best_answer_id,
        ]);
    }


    public function user($id): Model
    {
        return $this->model->find($id);
    }


    public function destroy($id): bool
    {
        return $this->model->find($id)->delete();
    }


}
