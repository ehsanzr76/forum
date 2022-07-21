<?php

namespace Tests\Unit\Http\Controllers\API\V01\Channel;

use App\Http\Controllers\API\V01\Channel\ChannelController;
use App\Models\Channel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChannelControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_channels_should_be_get()
    {
        $response = $this->get(route('channel.index'));
        $response->assertStatus(200);
    }


    public function test_creating_channel_should_be_validated()
    {
        $response = $this->postJson(route('channel.create'));
        $response->assertStatus(422);
    }


    public function test_create_channel()
    {
        $response = $this->postJson(route('channel.create'), [
            'name' => 'laravel'
        ]);
        $response->assertStatus(201);
    }


    public function test_updating_channel_should_be_validated()
    {
        $response = $this->json('PUT', route('channel.update'));
        $response->assertStatus(422);
    }


    public function test_update_channel()
    {
        $channel = Channel::factory()->create([
            'name' => 'laravel'
        ]);
        $response = $this->json('PUT', route('channel.update'), [
            'id' =>$channel->id,
            'name'=>'vuejs'
        ]);
        $response->assertStatus(200);
        $updateChannel = Channel::find($channel->id);
        $this->assertEquals('vuejs' ,  $updateChannel->name);
    }
}
