<?php

namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition()
    {
        return [
            'id_uzytkownika'   => $this->faker->numberBetween(1, 100),
            'id_wydarzenia'    => $this->faker->numberBetween(1, 100),
            'data_rezerwacji'  => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
