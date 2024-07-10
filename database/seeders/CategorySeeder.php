<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Martial Arts',
                'is_deleted' => false
            ],
            [
                'name' => 'Fitness',
                'is_deleted' => false
            ],
            [
                'name' => 'Yoga',
                'is_deleted' => false
            ],
            [
                'name' => 'Dance',
                'is_deleted' => false
            ]
        ];

        Category::insert($data);
    }
}
