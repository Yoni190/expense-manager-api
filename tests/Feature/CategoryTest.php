<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;

    public function test_user_can_access_categories () {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200);
    }

    public function test_unauthenticated_user_cannot_access_categories () {
        $user = User::factory()->create();

        $response = $this->getJson('/api/categories');

        $response->assertStatus(401);
    }

    public function test_user_can_create_categories () {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/categories', [
            'name' => 'Shopping'
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('categories', [
            'name' => 'Shopping'
        ]);
    }

    public function test_user_cannot_create_duplicate_categories () {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $user->categories()->create(['name' => 'Shopping']);

        $response = $this->postJson('/api/categories', [
            'name' => 'Shopping'
        ]);

        $response->assertStatus(422);
    }
}
