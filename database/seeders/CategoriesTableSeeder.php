<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\File;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Civil Supplies' => ['en' => 'Civil Supplies', 'fr' => 'Fournitures civiles', 'ln' => 'Mbango ya makanda', 'image' => 'civil_supplies.png'],
            'Electricals' => ['en' => 'Electricals', 'fr' => 'Équipements électriques', 'ln' => 'Lisanga ya elekakeli', 'image' => 'electricals.png'],
            'Plumbing' => ['en' => 'Plumbing', 'fr' => 'Plomberie', 'ln' => 'Bisangisi', 'image' => 'plumbing.png'],
            'Sanitary' => ['en' => 'Sanitary', 'fr' => 'Sanitaire', 'ln' => 'Mikanda', 'image' => 'sanitary.png'],
            'Paints & Finishes' => ['en' => 'Paints & Finishes', 'fr' => 'Peintures et finitions', 'ln' => 'Bosolo na malamu', 'image' => 'paints_and_finishes.png'],
            'Hardware' => ['en' => 'Hardware', 'fr' => 'Quincaillerie', 'ln' => 'Yɔkɛlisɛ', 'image' => 'hardware.png'],
        ];
        
        foreach ($categories as $categoryName => $attributes) {
            $category = new Category();
            $category->setTranslations('name', $attributes);
            // Check if the 'image' key exists in the category attributes
            if (isset($attributes['image'])) {
                $imagePath = storage_path('app/public/images/') . $attributes['image'];
                // Move the image to the public/images folder
                File::copy($imagePath, public_path('images/') . $attributes['image']);
                // Set the image attribute in the Category model
                $category->setImage($attributes['image']);
            }
        
            $category->save();
        }
    }

   
}
