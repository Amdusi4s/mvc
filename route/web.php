<?php

use app\controllers\LoginController,
    app\controllers\RegisterController,
    app\controllers\SiteController,
    app\controllers\CaptchaController;

/** @var $app \app\core\Application */

// route home page
$app->router->get('/', [SiteController::class, 'home']);
// route register page
$app->router->get('/register', [RegisterController::class, 'index']);
$app->router->post('/register', [RegisterController::class, 'index']);
// route login page
$app->router->get('/login', [LoginController::class, 'index']);
$app->router->post('/login', [LoginController::class, 'index']);
// route logout
$app->router->get('/logout', [LoginController::class, 'logout']);
// route captcha
$app->router->get('/captcha', [CaptchaController::class, 'generate']);