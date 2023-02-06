<?php

return [
    'class' => 'app\core\email\Email',
    'arguments' => [
        'config' => [
            'Host' => $_ENV['EMAIL_HOST'],
            'Port' => $_ENV['EMAIL_PORT'],
            'Username' => $_ENV['EMAIL_USER'],
            'Password' => $_ENV['EMAIL_PASSWORD'],
            'CharSet' => $_ENV['EMAIL_CHARSET'],
            'setFrom' => $_ENV['EMAIL_FROM'],
            'SMTPSecure' => $_ENV['EMAIL_SECURE']
        ]
    ]
];