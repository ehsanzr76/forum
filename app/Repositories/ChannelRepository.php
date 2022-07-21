<?php


namespace App\Repositories;


use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;

class ChannelRepository
{

    public function getAll(): Collection
    {
        return Channel::all();
    }


    public function create($name): void
    {
        Channel::create([
            'name' => $name,
            'slug' => str::slug($name)
        ]);
    }


    public function getUpdate($id, $name): void
    {
        Channel::find($id)->update([
            'name' => $name,
            'slug' => str::slug($name)
        ]);
    }

}
