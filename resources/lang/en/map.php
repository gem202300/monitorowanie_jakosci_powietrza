<?php
return [
    'title' => 'Map',
    'filter' => 'Filter',
    'fullscreen' => 'Fullscreen',
    'legend' => 'Legend',
    'select_parameter' => 'Select parameter',
    'choose_datetime' => 'Date / Time',
    'error' => [
        'choose_parameter' => 'Please select date/time and parameter!'
    ],
    'legend_items' => [
        'temperature' => [
            '>35°C (Very hot)',
            '30–35°C (Hot)',
            '20–30°C (Normal)',
            '<20°C (Cool)'
        ],
        'humidity' => [
            '<20% or >80% (Dangerous)',
            '20–30% (Low)',
            '30–60% (Optimal)',
            '60–80% (High)'
        ],
        'pressure' => [
            '<980 or >1030 hPa',
            '980–990 hPa',
            '990–1020 hPa',
            '1020–1030 hPa'
        ],
        'pm' => [
            'Good',
            'Acceptable',
            'Moderate',
            'Poor'
        ],
    ],
    'legend_none' => 'No description for this parameter',
];
