<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'date' => $this->faker->date(),
            'location' => $this->faker->city(),
            'max_participants' => $this->faker->numberBetween(10, 30),
        ];
    }
}

