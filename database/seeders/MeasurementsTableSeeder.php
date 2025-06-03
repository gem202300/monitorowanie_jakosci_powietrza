<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Measurement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MeasurementsTableSeeder extends Seeder
{
    public function run()
    {
        $devices = DB::table('devices')->pluck('id');

        foreach ($devices as $deviceId) {
            for ($i = 0; $i < 72; $i++) {
                $timestamp = Carbon::now()->subHours($i);

                Measurement::factory()->create([
                    'device_id' => $deviceId,
                    'date_time' => $timestamp,
                ]);
            }
        }
    }
}