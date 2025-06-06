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
                $value = $this->generateRealisticValue($param->parameter_id);

                DB::table('measurement_values')->insert([
                    'measurement_id' => $measurement->id,
                    'parameter_id' => $param->parameter_id,
                    'value' => $value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function generateRealisticValue($parameterId)
    {
        $parameter = DB::table('parameters')->where('id', $parameterId)->first();

        switch ($parameter->name) {
            case 'temperature':
                return rand(1500, 3500) / 100; 
            case 'humidity':
                return rand(3000, 9000) / 100; 
            case 'pressure':
                return rand(98000, 105000) / 100; 
            case 'pm1':
                return rand(0, 500) / 10; 
            case 'pm2_5':
                return rand(0, 800) / 10; 
            case 'pm10':
                return rand(0, 1000) / 10; 
            default:
                return rand(100, 10000) / 100; 
        }
    }
}
