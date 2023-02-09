<?php

use app\controllers\auth\LoginController,
    app\controllers\auth\RegisterController;

/** @var \app\core\Application $app */

// route register page
$app->router->get('/register', [RegisterController::class, 'index']);
$app->router->post('/register', [RegisterController::class, 'index']);
// route login page
$app->router->get('/login', [LoginController::class, 'index']);
$app->router->post('/login', [LoginController::class, 'index']);
// route logout
$app->router->get('/logout', [LoginController::class, 'logout']);