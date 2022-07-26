<?php


namespace App\Interfaces;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ThreadRepoInterface
{
    public function index(): Collection;
    public function show($slug): Model | null;
    public function create($title , $body): Model;
    public function update($id ,$title , $body , $best_answer_id = null): bool;
    public function destroy($id): bool;
    public function user($id): Model;

}
