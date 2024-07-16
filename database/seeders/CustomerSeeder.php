<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Customer::truncate();

        Customer::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'mobile_no' => '1234567890',
            'password' => bcrypt('password'),
            'purchased_credit' => 10,
            'package_id' => $this->getRandomPackageId(),
        ]);
        Customer::create([
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane.smith@example.com',
            'mobile_no' => '0987654321',
            'password' => bcrypt('password'),
            'purchased_credit' => 20,
            'package_id' => $this->getRandomPackageId(),
        ]);
        Customer::create([
            'first_name' => 'Alice',
            'last_name' => 'Johnson',
            'email' => 'alice.johnson@example.com',
            'mobile_no' => '1122334455',
            'password' => bcrypt('password'),
            'purchased_credit' => 30,
            'package_id' => $this->getRandomPackageId(),
        ]);
    }

    private function getRandomPackageId()
    {
        $package = Package::raw(function ($collection) {
            return $collection->aggregate([
                ['$sample' => ['size' => 1]]
            ]);
        })->first();

        return $package->_id;
    }
}
