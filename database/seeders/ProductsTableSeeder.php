<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Assuming you have category records in the categories table
        $categories = Category::all();

        foreach ($categories as $category) {
            for ($i = 0; $i < 5; $i++) {
                Product::create([
                    'name' => 'Product ' . ($i + 1),
                    'description' => 'Description for Product ' . ($i + 1),
                    'price' => rand(10, 100),
                    'category_id' => $category->id,
                    // Add more fields as needed
                ]);
            }
        }
    }
}
