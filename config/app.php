<?php

use app\models\user\User;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

return [
    // config db
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ],
    // config application
    'app' => [
        'name' => $_ENV['APP_NAME']
    ],
    'userClass' => User::class,
    'csrf' => [
        'key' => $_ENV['CSRF_TOKEN_KEY']
    ],
    'email' => [
        'Host' => $_ENV['EMAIL_HOST'],
        'Port' => $_ENV['EMAIL_PORT'],
        'Username' => $_ENV['EMAIL_USER'],
        'Password' => $_ENV['EMAIL_PASSWORD'],
        'CharSet' => $_ENV['EMAIL_CHARSET'],
        'setFrom' => $_ENV['EMAIL_FROM'],
        'SMTPSecure' => $_ENV['EMAIL_SECURE']
    ],
    'components' => [
        'request' => [
            'class' => 'app\core\Request',
            'params' => []
        ],
        'response' => [
            'class' => 'app\core\Response',
            'params' => []
        ],
        'session' => [
            'class' => 'app\core\Session',
            'params' => []
        ],
        'view' => [
            'class' => 'app\core\View',
            'params' => []
        ],
        'secure' => [
            'class' => 'app\core\secure\Secure',
            'params' => []
        ],
        'router' => [
            'class' => 'app\core\Router',
            'params' => []
        ],
        'database' => [
            'class' => 'app\core\db\Database',
            'params' => []
        ],
        'csrf' => [
            'class' => 'app\core\Csrf',
            'params' => []
        ],
        'email' => [
            'class' => 'app\core\email\Email',
            'params' => []
        ],
        'cache' => [
            'class' => 'app\core\Cache',
            'params' => []
        ]
    ]
];