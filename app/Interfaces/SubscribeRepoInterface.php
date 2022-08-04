<?php


namespace App\Interfaces;


use Illuminate\Database\Eloquent\Model;

interface SubscribeRepoInterface
{
    public function store($thread_id): Model;
    public function destroy($id , $thread_id): bool;
    public function notifiableUser($thread_id): array;
}
