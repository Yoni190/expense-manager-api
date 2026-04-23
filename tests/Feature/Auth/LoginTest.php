<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_successfully () {
        User::factory()->create([
            'email' => 'johndoe@gmail.com',
            'password' => '123456'
        ]);

        $response = $this->postJson('api/login', [
            'email' => 'johndoe@gmail.com',
            'password' => '123456'
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['token']);
    }

    public function test_user_login_with_missing_fields () {
        User::factory()->create([
            'email' => 'johndoe@gmail.com',
            'password' => '123456'
        ]);

        $response = $this->postJson('api/login', []);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['email', 'password']);
    }

    public function test_user_login_with_invalid_credentials () {
        User::factory()->create([
            'email' => 'johndoe@gmail.com',
            'password' => '123456'
        ]);

        $response = $this->postJson('api/login', [
            'email' => 'johnsmith@gmail.com',
            'password' => '123456'
        ]);

        $response->assertStatus(401);

        $response->assertJson(['message' => 'Invalid Credentials']);
    }
}
