<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParametersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('parameters')->insert([
            [
                'id' => 'param-001',
                'name' => 'temperature',
                'label' => 'Temperature',
                'unit' => '°C',
                'valueType' => 'float',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'param-002',
                'name' => 'humidity',
                'label' => 'Humidity',
                'unit' => '%',
                'valueType' => 'float',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'param-003',
                'name' => 'pressure',
                'label' => 'Atmospheric Pressure',
                'unit' => 'hPa',
                'valueType' => 'float',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'param-004',
                'name' => 'pm25',
                'label' => 'PM2.5',
                'unit' => 'µg/m³',
                'valueType' => 'float',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}