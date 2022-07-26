<?php


namespace API\v1\Thread;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
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

    public function test_create_answer_should_be_validate()
    {
        $response = $this->postJson(route('answers.store'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function test_can_create_answer()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->postJson(route('answers.store'), [
            'body' => 'this thread is very good',
            'thread_id' => Thread::factory()->create()->id,
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
    }

}
