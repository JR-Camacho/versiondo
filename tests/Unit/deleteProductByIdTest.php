<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class deleteProductByIdTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function deleteProductByIdTest()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();

        $response = $this->delete('/api/products/' . $product->id);

        $response->assertStatus(200);

        $response->assertJson([
            'status' => 'success',
        ]);
    }
}
