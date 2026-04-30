<?php

return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*', '*'],
    'allowed_origins' => [
        'https://etecgames.com.br',
        'https://www.etecgames.com.br',
    ],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
];
