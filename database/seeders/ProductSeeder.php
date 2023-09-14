<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Producto 1',
                'description' => 'Descripción del producto 1',
                'price' => 19.99,
                'stock' => 50,
                'category_id' => 1,
            ],
            [
                'name' => 'Producto 2',
                'description' => 'Descripción del producto 2',
                'price' => 29.99,
                'stock' => 30,
                'category_id' => 3,
            ],
            [
                'name' => 'Producto 3',
                'description' => 'Descripción del producto 3',
                'price' => 39.99,
                'stock' => 20,
                'category_id' => null,
            ],
            [
                'name' => 'Producto 4',
                'description' => 'Descripción del producto 4',
                'price' => 49.99,
                'stock' => 10,
                'category_id' => 3,
            ],
            [
                'name' => 'Producto 5',
                'description' => 'Descripción del producto 5',
                'price' => 59.99,
                'stock' => 5,
                'category_id' => 2,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
