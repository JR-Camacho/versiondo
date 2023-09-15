<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class createProductTest extends TestCase
{
    use DatabaseMigrations, WithFaker, RefreshDatabase;

    /** @test */
    public function createProductTest()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = [
            'name' => $this->faker->unique()->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 10, 100),
            'stock' => $this->faker->numberBetween(0, 100),
            'category_id' => $this->faker->numberBetween(1, 5)
        ];

        $response = $this->post('/api/products/', $product);

        $response->assertStatus(201);

        $product = Product::first();

        $response->assertJson([
            'status' => 'success',
            'message' => 'Product created successfully',
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'stock' => $product->stock,
                'category_id' => $product->category_id
            ],
        ]);
    }
}
