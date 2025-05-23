<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class WishlistTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_and_login()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(200)->assertJsonStructure(['token']);

        $response = $this->postJson('/api/login', [
            'email' => 'john@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)->assertJsonStructure(['token']);
    }

    public function test_user_can_add_and_remove_from_wishlist()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $token = $user->createToken('test-token')->plainTextToken;

        $this->withHeader('Authorization', "Bearer $token")
            ->postJson("/api/wishlist/{$product->id}")
            ->assertStatus(201)
            ->assertJson(['message' => 'Product added to wishlist']);

        $this->withHeader('Authorization', "Bearer $token")
            ->deleteJson("/api/wishlist/{$product->id}")
            ->assertStatus(200)
            ->assertJson(['message' => 'Removed from wishlist']);
    }

    public function test_fetching_user_wishlist()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $user->wishlist()->create(['product_id' => $product->id]);

        $token = $user->createToken('test-token')->plainTextToken;

        $this->withHeader('Authorization', "Bearer $token")
            ->getJson("/api/wishlist")
            ->assertStatus(200)
            ->assertJsonFragment(['id' => $product->id]);
    }
}
