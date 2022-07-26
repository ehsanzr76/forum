<?php


namespace App\Interfaces;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface AnswerRepoInterface
{
    public function index(): Collection;

    public function create($body, $thread_id): Model;

}
