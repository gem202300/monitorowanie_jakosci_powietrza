<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DevicesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('devices')->insert([
            [
                'id' => '1',
                'name' => 'Weather Station Alpha',
                'status' => 'active',
                'address' => '123 Main St, Kyiv',
                'longitude' => 30.5234,
                'latitude' => 50.4501,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '2',
                'name' => 'Air Quality Monitor Beta',
                'status' => 'active',
                'address' => '456 Park Ave, Lviv',
                'longitude' => 24.0316,
                'latitude' => 49.8429,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '3',
                'name' => 'Water Sensor Gamma',
                'status' => 'maintenance',
                'address' => '789 River Rd, Odesa',
                'longitude' => 30.7233,
                'latitude' => 46.4825,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}