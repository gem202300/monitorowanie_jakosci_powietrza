<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Notifications\GenericNotification;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\User::where('email', 'admin.test@localhost')->first();

$notifications = [
    ['title' => 'New Message 1', 'body' => 'This is the first test notification.'],
    ['title' => 'New Message 2', 'body' => 'This is the second test notification.'],
    ['title' => 'New Message 3', 'body' => 'This is the third test notification.'],
];

foreach ($notifications as $data) {
    $admin->notify(new \App\Notifications\GenericNotification($data));
}

    }
}