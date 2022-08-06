<?php


namespace API\v1\Thread;

use App\Models\Answer;
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
        $user = User::factory()->create();
        Sanctum::actingAs($user);
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


    public function test_update_answer_should_be_validate()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $answer = Answer::factory()->create();
        $response = $this->putJson(route('answers.update', $answer->id));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_can_update_answer()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $answer = Answer::factory()->create([
            'body' => 'foo',
            'thread_id' => Thread::factory()->create()->id,
            'user_id' => $user->id,


        ]);
        $response = $this->putJson(route('answers.update', $answer->id), [
            'id'=>$answer->id,
            'body' => 'bar',
            'thread_id' => Thread::factory()->create()->id,
            'user_id'=>$user->id,
        ])->assertSuccessful();

        $answer->refresh();
        $this->assertSame('bar', $answer->body);
    }

    public function test_can_delete_answer()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $answer = Answer::factory()->create([
            'user_id'=>$user->id,
        ]);
        $response = $this->deleteJson(route('answers.destroy', $answer->id), [
            'id' => $answer->id,
            'user_id'=>$user->id,
        ])->assertSuccessful();
        $this->assertFalse(Thread::find($answer->thread_id)->answers()->where('body', $answer->body)->exists());   ////when answer is deleted the thread_id in threads table should be deleted.
    }


    public function test_user_score_will_increase_by_submit_new_answer()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->postJson(route('answers.store'), [
            'body' => 'this thread is very good',
            'thread_id' => Thread::factory()->create()->id,
        ]);
        $response->assertSuccessful();
        $this->assertEquals(10 , $user->score);
    }

}
