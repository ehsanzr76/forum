<?php


namespace API\v1\Thread;

use App\Models\Subscribe;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SubscribeTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_store_subscription_should_be_validated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->postJson(route('subscribes.store'));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_user_can_subscribe_thread()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $thread = Thread::factory()->create();

        $response = $this->postJson(route('subscribes.store'), [
            'thread_id' => $thread->id,
            'user_id' => $user->id,
        ]);

        $response->assertSuccessful();
    }

    public function test_user_can_unsubscribe_thread()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $thread = Thread::factory()->create();
        $subscribe = Subscribe::factory()->create();

        $response = $this->deleteJson(route('subscribes.destroy' , $subscribe->id) ,[
            'id'=>$subscribe->id,
            'thread_id' => $thread->id,
            'user_id' => $user->id,
        ]);

        $response->assertSuccessful();
    }
}
