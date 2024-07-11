<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;
use MongoDB\BSON\ObjectId;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::truncate();
        $data = [
            [
                'name' => 'Martial Arts',
                'is_deleted' => false,
                'subcategories' => [
                    ['name' => 'Karate', 'is_deleted' => false],
                    ['name' => 'Judo', 'is_deleted' => false],
                ]
            ],
            [
                'name' => 'Fitness',
                'is_deleted' => false,
                'subcategories' => [
                    ['name' => 'Weightlifting', 'is_deleted' => false],
                    ['name' => 'Cardio', 'is_deleted' => false],
                ]
            ],
            [
                'name' => 'Yoga',
                'is_deleted' => false,
                'subcategories' => [
                    ['name' => 'Hatha', 'is_deleted' => false],
                    ['name' => 'Vinyasa', 'is_deleted' => false],
                ]
            ],
            [
                'name' => 'Dance',
                'is_deleted' => false,
                'subcategories' => [
                    ['name' => 'Ballet', 'is_deleted' => false],
                    ['name' => 'Hip-Hop', 'is_deleted' => false],
                ]
            ]
        ];

        foreach ($data as $categoryData) {
            $category = Category::create([
                'parent_id' => null,
                'name' => $categoryData['name'],
                'is_deleted' => $categoryData['is_deleted'],
            ]);
            foreach ($categoryData['subcategories'] as $subcategoryData) {
                Category::create([
                    'parent_id' =>  $category->_id, // Assuming _id is used as the primary key
                    'name' => $subcategoryData['name'],
                    'is_deleted' => $subcategoryData['is_deleted'],
                ]);
            }
        }
    }
}
