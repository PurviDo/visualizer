<?php

namespace Database\Seeders;

use App\Models\Cms\ContactUs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactUs::truncate();
        DB::table('contact_us')->insert([
            'title' => 'TechTelligence India',
            'email' => 'techtelligenceindia@gmail.com',
            'phone' => '+91 9399150791',
            'address' => '56/1/4 SK-1 Compound, Malviya Warehouse, Dewas Naka, Indore, Madhya Pradesh, India',
            'map_url' => ''
        ]);
    }
}
