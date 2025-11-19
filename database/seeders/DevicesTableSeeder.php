<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Device;
use App\Enums\Auth\RoleType;
use Illuminate\Database\Seeder;
use App\Models\DeviceAssignmentHistory;

class DevicesTableSeeder extends Seeder
{
    public function run()
    {
        $cities = [
            ['Warsaw', 52.2297, 21.0122],
            ['Krakow', 50.0647, 19.9450],
            ['Lodz', 51.7592, 19.4550],
            ['Wroclaw', 51.1079, 17.0385],
            ['Poznan', 52.4064, 16.9252],
            ['Gdansk', 54.3520, 18.6466],
            ['Szczecin', 53.4285, 14.5528],
            ['Bydgoszcz', 53.1235, 18.0084],
            ['Lublin', 51.2465, 22.5684],
            ['Katowice', 50.2649, 19.0238],
            ['Bialystok', 53.1325, 23.1688],
            ['Czestochowa', 50.8118, 19.1203],
            ['Radom', 51.4027, 21.1471],
            ['Rzeszow', 50.0412, 21.9991],
            ['Torun', 53.0138, 18.5984],
            ['Kielce', 50.8661, 20.6286],
            ['Gliwice', 50.2945, 18.6714],
            ['Olsztyn', 53.7784, 20.4801],
            ['Zielona Gora', 51.9356, 15.5064],
            ['Gorzow Wielkopolski', 52.7368, 15.2288],
            ['Tychy', 50.1372, 18.9846],
            ['Elblag', 54.1522, 19.4045],
            ['Plock', 52.5468, 19.7064],
            ['Kalisz', 51.7611, 18.0910],
        ];

        // Беремо адміна для поля assigned_by
        $admin = User::role(RoleType::ADMIN->value)->first();

        foreach ($cities as [$city, $lat, $lng]) {

            $device = Device::factory()->create([
                'name' => "Device $city",
                'address' => "$city, Poland",
                'latitude' => $lat,
                'longitude' => $lng,
            ]);

            $servicemen = User::role(RoleType::SERWISANT->value)->get();

            if ($servicemen->isNotEmpty()) {
                $serviceman = $servicemen->random();

                // Перевіряємо, чи не приписано
                if (!$serviceman->devices->contains($device->id)) {

                    // Поточне приписування
                    $serviceman->devices()->attach($device->id, [
                        'assign_at' => now()
                    ]);

                    // Запис в історію
                    DeviceAssignmentHistory::create([
                        'device_id'      => $device->id,
                        'user_id'        => $serviceman->id,
                        'assigned_by'    => $admin?->id ?? null,  // якщо раптом адміна немає
                        'assigned_at'    => now(),
                        'unassigned_at'  => null,
                    ]);
                }
            }
        }
    }
}
