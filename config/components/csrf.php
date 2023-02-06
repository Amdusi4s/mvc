<?php

return [
    'class' => 'app\core\Csrf',
    'arguments' => [
        'config' => [
            'key' => $_ENV['CSRF_TOKEN_KEY']
        ]
    ]
];