<?php


namespace App\Interfaces;


use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Collection;

interface UserRepoInterface
{
    public function create($name , $email , $password): Model;
    public function find($id): Model | Collection;

}
