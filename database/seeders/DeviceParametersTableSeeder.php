<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceParametersTableSeeder extends Seeder
{
    public function run()
    {
        $deviceIds = DB::table('devices')->pluck('id');
        $parameterIds = DB::table('parameters')->pluck('id');

        foreach ($deviceIds as $deviceId) {
            $assignedParams = $parameterIds->random(rand(2, 4));

            foreach ($assignedParams as $paramId) {
                DB::table('device_parameters')->insert([
                    'device_id' => $deviceId,
                    'parameter_id' => $paramId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
