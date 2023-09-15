<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class getProductByIdTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testGetProductByIdTest()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();

        $response = $this->get('/api/products/' . $product->id);

        $response->assertStatus(200);

        $response->assertJson([
            'status' => 'success',
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'stock' => $product->stock,
                'category_id' => $product->category_id
            ],
        ]);
    }
}
