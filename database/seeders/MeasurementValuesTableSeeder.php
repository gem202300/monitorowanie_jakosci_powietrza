<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MeasurementValuesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('measurement_values')->insert([
            // Measurements for device 1
            [
                'measurement_id' => 1,
                'parameter_id' => '1',
                'value' => 22.5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'measurement_id' => 1,
                'parameter_id' => '2',
                'value' => 45.2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'measurement_id' => 1,
                'parameter_id' => '3',
                'value' => 1012.3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'measurement_id' => 2,
                'parameter_id' => '1',
                'value' => 23.1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'measurement_id' => 2,
                'parameter_id' => '2',
                'value' => 43.8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Measurements for device 2
            [
                'measurement_id' => 4,
                'parameter_id' => '4',
                'value' => 12.7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'measurement_id' => 5,
                'parameter_id' => '4',
                'value' => 15.3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}