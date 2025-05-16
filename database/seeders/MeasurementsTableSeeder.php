<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MeasurementsTableSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        
        DB::table('measurements')->insert([
            [
                'device_id' => '1',
                'date_time' => $now->copy()->subHours(2),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'device_id' => '1',
                'date_time' => $now->copy()->subHours(1),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'device_id' => '1',
                'date_time' => $now,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'device_id' => '2',
                'date_time' => $now->copy()->subHours(3),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'device_id' => '2',
                'date_time' => $now,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}