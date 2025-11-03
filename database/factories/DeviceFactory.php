<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
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
        //'id' => Str::uuid()->toString(),
        'name' => $this->faker->word(),
        'status' => $this->faker->randomElement(['active', 'inactive', 'maintenance']),
        'address' => $this->faker->address(),
        'latitude' => $this->faker->latitude(49.0, 55.0),   
        'longitude' => $this->faker->longitude(14.0, 24.0), 
        'created_at' => now(),
        'updated_at' => now(),
    ];
}

}
