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
            'name' => 'Basic Free Package',
            'duration' => 6,
            'description' => 'A basic package for beginners',
            'credits' => 10,
            'actual_price' => 00.00,
            'discounted_price' => 00.00,
            'status' => 'Active',
        ]);

        Package::create([
            'name' => 'Standard Package',
            'duration' => 6,
            'description' => 'A standard package for intermediate users',
            'credits' => 20,
            'actual_price' => 180.00,
            'discounted_price' => 160.00,
            'status' => 'Active',
        ]);

        Package::create([
            'name' => 'Premium Package',
            'duration' => 6,
            'description' => 'A premium package for advanced users',
            'credits' => 50,
            'actual_price' => 300.00,
            'discounted_price' => 270.00,
            'status' => 'Inactive',
        ]);
    }
}
