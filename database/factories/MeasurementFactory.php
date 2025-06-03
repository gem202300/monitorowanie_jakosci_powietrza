<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class MeasurementFactory extends Factory
{
    public function definition()
    {
        return [
            'device_id' => null, // встановлюється вручну
            'date_time' => now()->subHours(rand(0, 72)),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
