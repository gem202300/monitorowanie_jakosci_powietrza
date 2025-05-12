<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    public function run()
    {
        $events = Event::all();

        $eventCounts = [];
        foreach ($events as $event) {
            $eventCounts[$event->id] = Reservation::where('id_wydarzenia', $event->id)->count();
        }

        $totalToCreate = 1100;  
        $created = 0;

        while ($created < $totalToCreate) {
           
            $availableEvents = $events->filter(function ($event) use ($eventCounts) {  // filtr z wydarzeniami 
                return $eventCounts[$event->id] < $event->max_participants;
            });

           
            if ($availableEvents->isEmpty()) {
                break;
            }

            $event = $availableEvents->random();

            Reservation::factory()->create([
                'id_wydarzenia' => $event->id,
            ]);

            $eventCounts[$event->id]++;
            $created++;
        }
    }
}
