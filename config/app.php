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
    ]
];