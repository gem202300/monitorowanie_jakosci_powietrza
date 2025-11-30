<?php
return [
    'title' => 'Mapa',
    'filter' => 'Filtr',
    'fullscreen' => 'Pełny ekran',
    'legend' => 'Legenda',
    'select_parameter' => 'Wybierz parametr',
    'choose_datetime' => 'Data / Godzina',
    'error' => [
        'choose_parameter' => 'Wybierz datę/czas i parametr!'
    ],
    'legend_items' => [
        'temperature' => [
            '>35°C (Bardzo gorąco)',
            '30–35°C (Gorąco)',
            '20–30°C (Normalnie)',
            '<20°C (Chłodno)'
        ],
        'humidity' => [
            '<20% lub >80% (Niebezpieczne)',
            '20–30% (Niska)',
            '30–60% (Optymalna)',
            '60–80% (Wysoka)'
        ],
        'pressure' => [
            '<980 lub >1030 hPa',
            '980–990 hPa',
            '990–1020 hPa',
            '1020–1030 hPa'
        ],
        'pm' => [
            'Dobry',
            'Akceptowalny',
            'Umiarkowany',
            'Zły'
        ],
    ],
    'legend_none' => 'Brak opisu dla tego parametru',
];
