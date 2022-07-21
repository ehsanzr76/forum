<?php

namespace Tests\Unit\Http\Controllers\API\V01\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;


    public function test_register_user_should_be_validate()
    {
        $response = $this->postJson(route('auth.register'));
        $response->assertStatus(422);
    }


    public function test_user_can_register()
    {
        $response = $this->registerNewUser();
        $response->assertStatus(201);
    }


    public function test_login_user_should_be_validate()
    {
        $response = $this->postJson(route('auth.login'));
        $response->assertStatus(422);
    }


    public function test_user_can_login_with_email()
    {
        $user = User::factory()->create();
        $response = $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password'
        ]);
        $response->assertStatus(200);
    }


    public function test_user_logged_in_can_logout()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson(route('auth.logout'));
        $response->assertStatus(200);
    }


    public function test_user_logged_in_can_show_his_account()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('auth.user'));
        $response->assertStatus(200);
    }


    /**
     * @return \Illuminate\Testing\TestResponse
     */
    public function registerNewUser()
    {
        return $this->postJson(route('auth.register'), [
            'name' => 'ehsan',
            'email' => 'ehsanzr538@gmail.com',
            'password' => 123456
        ]);
    }
}
