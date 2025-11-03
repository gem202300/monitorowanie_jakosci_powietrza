<?php

namespace Database\Seeders;

use App\Models\Device;
use App\Models\DeviceRepair;
use Illuminate\Database\Seeder;

class DeviceRepairSeeder extends Seeder
{
    public function run(): void
    {
        $devices = Device::all();

        foreach ($devices as $device) {
            DeviceRepair::factory()
                ->count(rand(1, 4)) // від 1 до 4 записів для кожного девайсу
                ->create(['device_id' => $device->id]);
        }

        $this->command->info('✅ DeviceRepairSeeder: Repairs generated for each device!');
    }
}
