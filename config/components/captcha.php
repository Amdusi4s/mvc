<?php

return [
    'class' => 'app\core\captcha\Captcha',
    'arguments' => [
        'config' => [
            'type' => $_ENV['CAPTCHA_TYPE'],
            'enabled' => (bool) $_ENV['CAPTCHA_STATUS'],
            'types' => ['default', 'recaptcha'],
            'default' => [
                'size' => ['width' => 168, 'height' => 37],
                'bg' => [54, 201, 95],
                'color' => [255, 255, 255]
            ],
            'recaptcha' => [
                'site' => $_ENV['RECAPTCHA_SITE'],
                'private' => $_ENV['RECAPTCHA_PRIVATE']
            ]
        ]
    ],
    'method' => 'getDriver',
    'sort' => 12
];