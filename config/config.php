<?php

return [
    'web_executing' => [
        'enabled' => true,
        'only_tager_commands' => true,
    ],
    'queue' => [
        'connection' => 'redis',
        'name' => 'default',
    ]
];
