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
                'device_id' => 'dvc-001',
                'parameter_id' => 'param-001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'device_id' => 'dvc-001',
                'parameter_id' => 'param-002',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'device_id' => 'dvc-001',
                'parameter_id' => 'param-003',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'device_id' => 'dvc-002',
                'parameter_id' => 'param-004',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'device_id' => 'dvc-003',
                'parameter_id' => 'param-001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}