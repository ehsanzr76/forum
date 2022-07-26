<?php


namespace API\v1\Thread;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnswerTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_answers_can_get()
    {
        $this->withExceptionHandling();
        $response = $this->getJson(route('answers.index'));
        $response->assertSuccessful();

    }
}
