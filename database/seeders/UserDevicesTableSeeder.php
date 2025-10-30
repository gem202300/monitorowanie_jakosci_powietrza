<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserDevicesTableSeeder extends Seeder
{
    public function run()
    {
        // Assuming you have users with IDs 1, 2, and 3
        DB::table('user_devices')->insert([
            [
                'user_id' => 1,
                'device_id' => 'dvc-001',
                'assign_at' => Carbon::now()->subDays(30),
                'unassign_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'device_id' => 'dvc-002',
                'assign_at' => Carbon::now()->subDays(15),
                'unassign_at' => Carbon::now()->subDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'device_id' => 'dvc-003',
                'assign_at' => Carbon::now()->subDays(10),
                'unassign_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}