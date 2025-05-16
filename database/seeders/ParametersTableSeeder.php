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
                'id' => '1',
                'name' => 'temperature',
                'label' => 'Temperature',
                'unit' => '°C',
                'valueType' => 'float',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '2',
                'name' => 'humidity',
                'label' => 'Humidity',
                'unit' => '%',
                'valueType' => 'float',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '3',
                'name' => 'pressure',
                'label' => 'Atmospheric Pressure',
                'unit' => 'hPa',
                'valueType' => 'float',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '4',
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