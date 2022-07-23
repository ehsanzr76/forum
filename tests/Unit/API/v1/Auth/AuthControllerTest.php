<?php

namespace Tests\Unit\API\v1\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;


    public function test_register_user_should_be_validate()
    {
        $response = $this->postJson(route('auth.register'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function test_user_can_register()
    {
        $response = $this->registerNewUser();
        $response->assertStatus(Response::HTTP_CREATED);
    }


    public function test_login_user_should_be_validate()
    {
        $response = $this->postJson(route('auth.login'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function test_user_can_login_with_email()
    {
        $user = User::factory()->create();
        $response = $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password'
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }


    public function test_user_logged_in_can_logout()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson(route('auth.logout'));
        $response->assertStatus(Response::HTTP_OK);
    }


    public function test_user_logged_in_can_show_his_account()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('auth.user'));
        $response->assertStatus(Response::HTTP_OK);
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
