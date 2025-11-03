<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Device;
use App\Models\DeviceRepair;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceRepairFactory extends Factory
{
    protected $model = DeviceRepair::class;

    public function definition(): array
    {
        $isFailure = $this->faker->boolean(60); // 60% шанс, що це "awaria"

        return [
            'device_id' => Device::inRandomOrder()->first()?->id ?? Device::factory(),
            'user_id' => User::inRandomOrder()->first()?->id ?? null,
            'type' => $isFailure ? 'failure' : 'repair',
            'description' => $isFailure
                ? $this->faker->sentence(8, true)
                : 'Naprawiono: ' . $this->faker->sentence(5, true),
            'reported_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'resolved_at' => $isFailure
                ? (rand(0, 1) ? $this->faker->dateTimeBetween('-2 months', 'now') : null)
                : $this->faker->dateTimeBetween('-2 months', 'now'),
        ];
    }
}
