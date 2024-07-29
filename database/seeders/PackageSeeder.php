<?php

namespace Database\Seeders;

use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Package::truncate();
        Package::create([
            'name' => 'Free',
            'duration' => 6,
            'tagline' => 'In the Free plan you get access to',
            'description' => '',
            'credits' => 10,
            'price_per_image' => 00.00,
            'actual_price' => 00.00,
            'discounted_price' => 00.00,
            'status' => 'Active',
        ]);

        Package::create([
            'name' => 'Bronze',
            'duration' => 6,
            'tagline' => 'In the Bronze plan you get access to',
            'description' => '',
            'credits' => 100,
            'price_per_image' => 50.00,
            'actual_price' => 5000.00,
            'discounted_price' => 5000.00,
            'status' => 'Active',
        ]);
    }
}
