<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MeasurementValuesTableSeeder extends Seeder
{
    
    public function run()
    {
        $measurements = DB::table('measurements')->get();
        $deviceParams = DB::table('device_parameters')->get()->groupBy('device_id');

        foreach ($measurements as $measurement) {
            $params = $deviceParams[$measurement->device_id] ?? collect();

            foreach ($params as $param) {
                DB::table('measurement_values')->insert([
                    'measurement_id' => $measurement->id,
                    'parameter_id' => $param->parameter_id,
                    'value' => rand(10, 100) + (rand(0, 99) / 100),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}