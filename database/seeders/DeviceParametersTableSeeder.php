<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceParametersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('device_parameters')->insert([
            [
                'device_id' => '1',
                'parameter_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'device_id' => '1',
                'parameter_id' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'device_id' => '1',
                'parameter_id' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'device_id' => '2',
                'parameter_id' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'device_id' => '3',
                'parameter_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}