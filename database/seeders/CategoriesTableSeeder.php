<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          // You can adjust the number of categories and their names as needed
          $categories = [
            'Civil Supplies' => ['en' => 'Civil Supplies', 'fr' => 'Fournitures civiles', 'ln' => 'Mbango ya makanda'],
            'Electricals' => ['en' => 'Electricals', 'fr' => 'Équipements électriques', 'ln' => 'Lisanga ya elekakeli'],
            'Plumbing' => ['en' => 'Plumbing', 'fr' => 'Plomberie', 'ln' => 'Bisangisi'],
            'Sanitary' => ['en' => 'Sanitary', 'fr' => 'Sanitaire', 'ln' => 'Mikanda'],
            'Paints & Finishes' => ['en' => 'Paints & Finishes', 'fr' => 'Peintures et finitions', 'ln' => 'Bosolo na malamu'],
            'Hardware' => ['en' => 'Hardware', 'fr' => 'Quincaillerie', 'ln' => 'Yɔkɛlisɛ']
        ];

        foreach ($categories as $categoryName => $translations) {
            $category = new Category();
            $category->setTranslations('name', $translations);
            $category->save();
        }
    }
}
