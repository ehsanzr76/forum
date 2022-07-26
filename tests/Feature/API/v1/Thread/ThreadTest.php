<?php

namespace Tests\Feature\API\v1\Thread;


use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_threads_should_be_accessible()
    {
        $response = $this->getJson(route('threads.index'));
        $response->assertStatus(Response::HTTP_OK);
    }


    public function test_showThread_should_be_accessible_by_slug()
    {
        $thread = Thread::factory()->create();
        $response = $this->get(route('threads.index'), [$thread->slug]);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_create_thread_should_be_validate()
    {
        $response = $this->postJson(route('threads.store'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function test_can_create_thread()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->postJson(route('threads.store' ),[
            'title' => 'faaa',
            'body' => 'saaa',
            'channel_id' => Channel::factory()->create()->id,
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
    }


    public function test_updating_thread_should_be_validate()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $thread = Thread::factory()->create();
        $response = $this->putJson(route('threads.update', [$thread]));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function test_can_update_thread()
    {
        $this->withExceptionHandling();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $thread = Thread::factory()->create([
            'title' => 'faaa',
            'body' => 'saaa',
            'channel_id' => Channel::factory()->create()->id,
            'best_answer_id' => 2,
            'user_id' => $user->id,
        ]);
        $response = $this->putJson(route('threads.update', $thread->id), [
            'id' => $thread->id,
            'title' => 'baaa',
            'body' => 'kaaa',
            'channel_id' => Channel::factory()->create()->id,
            'best_answer_id' => 3,
            'user_id' => $user->id,


        ])->assertSuccessful();

        $thread->refresh();
        $this->assertSame('baaa', $thread->title);
        $this->assertSame(3, $thread->best_answer_id);

    }


    public function test_can_delete_thread()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $thread = Thread::factory()->create([
            'user_id' => $user->id,
        ]);
        $response = $this->deleteJson(route('threads.destroy', $thread->id), [
            'id' => $thread->id,
            'user_id' => $user->id,
        ])->assertSuccessful();
    }


}
