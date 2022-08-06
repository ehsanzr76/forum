<?php


namespace App\Interfaces;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Collection;

interface UserRepoInterface
{
    public function create($name, $email, $password): Model;

    public function find($id): Model|Collection;

    public function index(): LengthAwarePaginator;
    public function userBlock(): bool;

}
