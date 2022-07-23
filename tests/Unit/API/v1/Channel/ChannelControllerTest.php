<?php

namespace Tests\Unit\API\v1\Channel;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ChannelControllerTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;


    public function test_all_channels_should_be_get()
    {
        $response = $this->get(route('channel.index'));
        $response->assertStatus(Response::HTTP_OK);
    }


    public function test_creating_channel_should_be_validated()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('channel_management');
        $response = $this->actingAs($user)->postJson(route('channel.create'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function test_create_channel()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('channel_management');
        $response = $this->actingAs($user)->postJson(route('channel.create'), [
            'name' => 'laravel'
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
    }


    public function test_updating_channel_should_be_validated()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('channel_management');
        $response = $this->actingAs($user)->json('PUT', route('channel.update'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function test_update_channel()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('channel_management');
        $channel = Channel::factory()->create([
            'name' => 'laravel'
        ]);
        $response = $this->actingAs($user)->json('PUT', route('channel.update'), [
            'id' =>$channel->id,
            'name'=>'vuejs'
        ]);
        $updateChannel = Channel::find($channel->id);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertEquals('vuejs' ,  $updateChannel->name);
    }



    public function test_deleting_channel_should_be_validated()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('channel_management');
        $response = $this->actingAs($user)->json('DELETE', route('channel.delete'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function test_delete_channel()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('channel_management');
        $channel = Channel::factory()->create();
        $response = $this->actingAs($user)->json('DELETE' , route('channel.delete') , [
           'id'=>$channel->id
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }

}
