<?php


namespace App\Interfaces;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ChannelRepoInterface
{
    public function getAll(): Collection;

    public function create($name): Model;

    public function getUpdate($id, $name): bool;

    public function getDestroy($id): bool;

}
