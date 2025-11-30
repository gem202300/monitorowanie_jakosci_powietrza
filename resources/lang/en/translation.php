<?php

use App\Enums\Auth\RoleType;

return [
    'navigation' => [
        'dashboard'        => 'Dashboard',
        'users'            => 'Users',
        'events'           => 'Events',
        'reservations'     => 'Registrations',
        'my_reservations'  => 'My registrations',
    ],
    'attributes' => [
        'actions'    => 'Actions',
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
        'deleted_at' => 'Deleted at',
    ],
    'placeholder' => [
        'enter'  => 'Enter',
        'select' => 'Select',
    ],
    'roles' => [
        RoleType::ADMIN->value     => 'Administrator',
        RoleType::USER->value      => 'User',
        RoleType::SERWISANT->value => 'Serviceman',
    ],
    'messages' => [
        'successes' => [
            'stored_title'  => 'Created',
            'updated_title' => 'Updated',
        ],
    ],
];