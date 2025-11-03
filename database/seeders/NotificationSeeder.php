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
        $admin = User::where('email', 'admin.test@localhost')->first();

        if (!$admin) {
            $this->command->info('Admin user not found. Skipping notifications.');
            return;
        }

        $notifications = [
            [
                'title' => 'New Message 1',
                'body' => 'This is the text of the first notification.',
            ],
            [
                'title' => 'New Message 2',
                'body' => 'Here comes the second notification for testing purposes.',
            ],
            [
                'title' => 'New Message 3',
                'body' => 'Finally, this is the third notification example.',
            ],
        ];

        foreach ($notifications as $data) {
            $admin->notify(new GenericNotification($data));
        }

        $this->command->info('3 notifications created for the admin user.');
    }
}