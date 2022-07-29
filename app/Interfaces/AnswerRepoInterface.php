<?php


namespace App\Interfaces;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface AnswerRepoInterface
{
    public function index(): Collection;

    public function create($body, $thread_id): Model;
    public function update($body): int;
    public function destroy($id): bool;
    public function user($user_id): Model | null;

}
