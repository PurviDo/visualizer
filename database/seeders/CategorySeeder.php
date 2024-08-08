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
                'name' => 'Men',
                'is_deleted' => 0,
                'subcategories' => [
                    ['name' => 'Shirt', 'is_deleted' => 0],
                    ['name' => 'Kurta', 'is_deleted' => 0],
                ]
            ],
            [
                'name' => 'Women',
                'is_deleted' => 0,
                'subcategories' => [
                    ['name' => 'Saree', 'is_deleted' => 0],
                    ['name' => 'Kurti', 'is_deleted' => 0],
                ]
            ],
            [
                'name' => 'Furniture',
                'is_deleted' => 0,
                'subcategories' => []
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
