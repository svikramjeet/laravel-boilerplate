<?php

return [

    'fetch' => PDO::FETCH_CLASS,
    'default' => env('DB_CONNECTION', 'pgsql'),
    'connections' => [
        'pgsql' => [
            'driver'   => 'pgsql',
            'url'     => env("DATABASE_URL")
        ],
    ],
    'migrations' => 'migrations',
        'redis' => [
            'client' => 'predis',
            'default' => [
                'url'     => env("REDIS_URL")
                ],

        ],
];
