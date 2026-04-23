<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_can_register_successfully () {
        $response = $this->postJson('/api/register', [
            'f_name' => 'John',
            'l_name' => 'Doe',
            'email' => 'johndoe@gmail.com',
            'password' => '123456'
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                    'message' => 'User registered successfully'
                 ]);
        $this->assertDatabaseHas('users', [
            'email' => 'johndoe@gmail.com'
        ]);
    }

    public function test_user_register_with_missing_fields () {
        $response = $this->postJson('/api/register', []);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'f_name',
            'l_name',
            'email',
            'password'
        ]);
    }
}
