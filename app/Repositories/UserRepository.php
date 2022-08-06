<?php

namespace App\Repositories;

use App\Interfaces\UserRepoInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Database\Eloquent\Collection;
use \Illuminate\Contracts\Pagination\LengthAwarePaginator;
use phpDocumentor\Reflection\DocBlock\Tags\Author;

class UserRepository implements UserRepoInterface
{

    private \Illuminate\Database\Eloquent\Builder $model;

    public function __construct()
    {
        $this->model = User::query();
    }

    public function index(): LengthAwarePaginator
    {
        return $this->model->orderByDesc('score')->paginate(10);
    }

    public function create($name, $email, $password): Model
    {
       return $this->model->create([
           'name'=>$name,
           'email'=>$email,
           'password'=>Hash::make($password)
        ]);
    }

    public function find($id): Model | Collection
    {
        return $this->model->find($id);
    }

    public function userBlock(): bool
    {
        return (bool) auth()->user()->is_block;
    }

}
