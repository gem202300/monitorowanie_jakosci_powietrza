<?php

return [

    'labels' => [
        'create_form_title' => 'Tworzenie urządzenia',
        'edit_form_title'   => 'Edycja urządzenia',
    ],
    'history' => [
        'assignment_history_for_device' => 'Historia przypisań urządzenia: :name',
        'assigned_by' => 'Kto przypisał',
        'assigned_to' => 'Kogo przypisano',
        'assigned_at' => 'Data przypisania',
        'unassigned_at' => 'Data odpisania',
        'no_assignment_history' => 'Brak historii przypisań',
    ],
    'repairs' => [
        'title_prefix' => 'Historia awarii i napraw - ',
        'back_to_devices' => '← Powrót do listy urządzeń',
        'no_records' => 'Brak zapisów historii.',
        'type' => [
            'failure' => 'Awaria',
            'repair' => 'Naprawa',
        ],
        'type_heading' => 'Typ',
        'description' => 'Opis',
        'reported_at' => 'Zgłoszono',
        'resolved_at' => 'Naprawiono',
        'serviceman' => 'Serwisant',
    ],

    'actions' => [
        'create' => 'Utwórz',
        'edit'   => 'Zapisz zmiany',
        'delete' => 'Usuń',
        'cancel' => 'Anuluj',
    ],

    'attributes' => [
        'name'       => 'Nazwa urządzenia',
        'status'     => 'Status',
        'address'    => 'Adres',
        'longitude'  => 'Długość geograficzna',
        'latitude'   => 'Szerokość geograficzna',
        'parameters' => 'Mierzone parametry',
    ],

    'measurements' => [
        'measurements_for_device' => 'Pomiary dla urządzenia: :name',
        'device_info' => 'Informacje o urządzeniu',
        'report_issue' => 'Zgłoś problem',
        'reason' => 'Powód',
        'select_reason' => 'Wybierz powód',
        'incorrect_data' => 'Niepoprawne dane',
        'device_offline' => 'Urządzenie nie działa',
        'other' => 'Inne',
        'description' => 'Opis',
        'optional_description' => 'Opcjonalny opis...',
        'cancel' => 'Anuluj',
        'send' => 'Wyślij',
        'parameters' => 'Parametry',
        'unit' => 'Jednostka',
        'value_type' => 'Typ',
        'measurements' => 'Pomiary',
        'date_time' => 'Data/Czas',
        'no_measurements' => 'Brak pomiarów dla tego urządzenia.',
        'no_data' => 'Brak danych',
        'send_error' => 'Błąd podczas wysyłania',
    ],

];
