<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device>
 */
class DeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    
    public function definition(): array
{
    return [
        'id' => Str::uuid()->toString(),
        'name' => $this->faker->word(),
        'status' => $this->faker->randomElement(['active', 'inactive', 'maintenance']),
        'address' => $this->faker->address(),
        'longitude' => $this->faker->longitude(),
        'latitude' => $this->faker->latitude(),
    ];
}

}
