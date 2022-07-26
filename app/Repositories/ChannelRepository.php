<?php


namespace App\Repositories;


use App\Interfaces\ChannelRepoInterface;
use App\Models\Channel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;

class ChannelRepository implements ChannelRepoInterface
{

    private \Illuminate\Database\Eloquent\Builder $model;

    public function __construct()
    {
        $this->model = Channel::query();
    }

//Query All Channel
    public function index(): Collection
    {
        return $this->model->get();
    }

//Query Create Channel
    public function create($name): Model
    {
        return $this->model->create([
            'name' => $name,
            'slug' => Str::slug($name)
        ]);
    }

//Query Update Channel
    public function update($id, $name): bool
    {
        return $this->model->find($id)->update([
            'name' => $name,
            'slug' => Str::slug($name)
        ]);
    }

//Query Delete Channel
    public function destroy($id): bool
    {
        return $this->model->find($id)->delete();
    }

}
