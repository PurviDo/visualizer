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
            'tagline' => 'In the free plan you get access to:',
            'description' => '<ul><li><span style=\"font-size: 1rem;\">CamClo3D software to digitally drape your garments online</span><br></li><li>100+ templates for draping sarees and visualizing kurtas, kurtis, shirts etc. from fabric images</li><li>10 free credits to generate images. Each credit is worth 1 image and the images will be generated with a watermark.</li></ul>',
            'credits' => 10,
            'price_per_image' => 00.00,
            'actual_price' => 00.00,
            'discounted_price' => 00.00,
            'status' => 'Active',
        ]);

        Package::create([
            'name' => 'Bronze',
            'duration' => 6,
            'tagline' => 'In the bronze plan you get access to:',
            'description' => '<ul><li>CamClo3D software to digitally drape your garments online</li><li>100+ templates for draping sarees and visualizing kurtas, kurtis, shirts etc. from fabric images</li><li>100 credits to generate images. Each credit is worth 1 image.</li><li>Note - Credits are only valid for 6 months from the date of purchase.</li></ul>',
            'credits' => 100,
            'price_per_image' => 50.00,
            'actual_price' => 5000.00,
            'discounted_price' => 5000.00,
            'status' => 'Active',
        ]);

        Package::create([
            'name' => 'Silver',
            'duration' => 6,
            'tagline' => 'In the silver plan you get access to:',
            'description' => '<ul><li></li><li>CamClo3D software to digitally drape your garments online</li><li>100+ templates for draping sarees and visualizing kurtas, kurtis, shirts etc. from fabric images</li><li>175 credits to generate images. Each credit is worth 1 image.</li><li>Note - Credits are only valid for 6 months from the date of purchase.</li></ul>',
            'credits' => 175,
            'price_per_image' => 45.00,
            'actual_price' => 7500.00,
            'discounted_price' => 7500.00,
            'status' => 'Active',
        ]);

        Package::create([
            'name' => 'Gold',
            'duration' => 6,
            'tagline' => 'In the gold plan you get access to:',
            'description' => '<ul><li>CamClo3D software to digitally drape your garments online</li><li>100+ templates for draping sarees and visualising kurtas, kurtis, shirts etc. from fabric images</li><li>275 credits to generate images. Each credit is worth 1 image.</li><li>Note - Credits are only valid for 6 months from the date of purchase.</li></ul>',
            'credits' => 275,
            'price_per_image' => 36.00,
            'actual_price' => 10000.00,
            'discounted_price' => 10000.00,
            'status' => 'Active',
        ]);
    }
}
