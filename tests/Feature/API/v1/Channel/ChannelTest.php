<?php

namespace Tests\Feature\API\v1\Channel;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;


    public function test_all_channels_should_be_get()
    {
        $response = $this->getJson(route('channel.index'));
        $response->assertStatus(Response::HTTP_OK);
    }


    public function test_creating_channel_should_be_validated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel_management');
        $response = $this->postJson(route('channel.create'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function test_create_channel()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel_management');
        $response = $this->postJson(route('channel.create'), [
            'name' => 'laravel'
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
    }


    public function test_updating_channel_should_be_validated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel_management');
        $response = $this->json('PUT', route('channel.update'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function test_update_channel()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel_management');
        $channel = Channel::factory()->create([
            'name' => 'laravel'
        ]);
        $response = $this->json('PUT', route('channel.update'), [
            'id' =>$channel->id,
            'name'=>'vuejs'
        ]);
        $updateChannel = Channel::query()->find($channel->id);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertEquals('vuejs' ,  $updateChannel->name);
    }



    public function test_deleting_channel_should_be_validated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel_management');
        $response = $this->json('DELETE', route('channel.delete'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function test_delete_channel()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel_management');
        $channel = Channel::factory()->create();
        $response = $this->json('DELETE' , route('channel.delete') , [
           'id'=>$channel->id
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }

}
