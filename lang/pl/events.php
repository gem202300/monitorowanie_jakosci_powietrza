<?php

return [
    'attributes' => [
        'id'               => 'ID',
        'name'             => 'Nazwa',
        'description'      => 'Opis',
        'date'             => 'Data',
        'location'         => 'Lokalizacja',
        'max_participants' => 'Maksymalna liczba uczestników',
        'registered_count' => 'Zarejestrowani / Maksymalnie',
        'created_at'       => 'Data utworzenia',
        'view_reservations'=> 'Pokaż rezerwacje',
    ],
    'labels' =>[
        'edit_form_title' => 'Edycja forma',
        'create_form_title' => 'Utworzyć wydarzenie',
    ],
    'actions' => [
        'actions'           => 'Akcje',
        'create'            => 'Dodaj wydarzenie',
        'edit'              => 'Edytuj wydarzenie',
        'destroy'           => 'Usuń wydarzenie',
        'restore'           => 'Przywróć wydarzenie',
        'register'          => 'Zarejestruj się',
        'view_reservations' => 'Pokaż rezerwacje',
        'unregister'        => 'Anuluj rejestrację',
    ],
    'dialogs' => [
        'delete' => [
            'title'       => 'Usuwanie wydarzenia',
            'description' => 'Czy na pewno usunąć wydarzenie :name?',
        ],
        'restore' => [
            'title'       => 'Przywracanie wydarzenia',
            'description' => 'Czy na pewno przywrócić wydarzenie :name?',
        ],
    ],
    'messages' => [
        'successes' => [
            'stored'     => 'Dodano wydarzenie :name',
            'updated'    => 'Zaktualizowano wydarzenie :name',
            'destroyed'  => 'Usunięto wydarzenie :name',
            'restored'   => 'Przywrócono wydarzenie :name',
            'registered' => 'Pomyślnie zarejestrowano na wydarzenie :name.',
        ],
        'errors' => [
            'already_registered' => 'Jesteś już zarejestrowany na to wydarzenie.',
            'event_full'         => 'Wydarzenie jest pełne. Nie można dokonać rejestracji.',
        ],
    ],
];
