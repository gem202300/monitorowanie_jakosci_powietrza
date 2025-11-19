<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserDevicesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('user_devices')->insert([
            [
                'user_id' => 1,
                'device_id' => 1, // <- замінив на 1
                'assign_at' => Carbon::now()->subDays(30),
                'unassign_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'device_id' => 2, // <- замінив на 2
                'assign_at' => Carbon::now()->subDays(15),
                'unassign_at' => Carbon::now()->subDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'device_id' => 3, // <- замінив на 3
                'assign_at' => Carbon::now()->subDays(10),
                'unassign_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
