<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\User;
use App\Models\UserPackages;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();

        // Admin
        User::create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'password' => bcrypt('123456'),
            'email' => 'admin@visualizer.com',
            'mobile_no' => '1234567890',
            'purchased_credit' => 0,
            'package_id' => "1",
            'user_type' => 1,
            'is_active' => '1',
            'otp' => null,
            'deleted_at' => null,
        ]);

        User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'mobile_no' => '1234567890',
            'password' => bcrypt('12345678'),
            'purchased_credit' => 10,
            'package_id' => "1",
            'user_type' => 0,
            'is_active' => '1',
            'otp' => null,
            'deleted_at' => null,
        ]);

        $user = User::where('email','john.doe@example.com')->first();
        $package = Package::first();
        $startDate = Carbon::now();
        $endDate = $startDate->copy()->addMonths($package->duration);
        UserPackages::create([
            'package_id' => $package->_id,
            'user_id' => $user->_id,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);

    }
}
