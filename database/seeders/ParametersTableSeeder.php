<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParametersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('parameters')->insert([
            [
                //'id' => (string) Str::uuid(),
                'name' => 'temperature',
                'label' => 'Temperature',
                'unit' => '°C',
                'valueType' => 'float',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                //'id' => (string) Str::uuid(),
                'name' => 'humidity',
                'label' => 'Humidity',
                'unit' => '%',
                'valueType' => 'float',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                //'id' => (string) Str::uuid(),
                'name' => 'pressure',
                'label' => 'Atmospheric Pressure',
                'unit' => 'hPa',
                'valueType' => 'float',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                //'id' => (string) Str::uuid(),
                'name' => 'pm1',
                'label' => 'PM1',
                'unit' => 'µg/m³',
                'valueType' => 'float',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                //'id' => (string) Str::uuid(),
                'name' => 'pm2_5',
                'label' => 'PM2.5',
                'unit' => 'µg/m³',
                'valueType' => 'float',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                //'id' => (string) Str::uuid(),
                'name' => 'pm10',
                'label' => 'PM10',
                'unit' => 'µg/m³',
                'valueType' => 'float',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
