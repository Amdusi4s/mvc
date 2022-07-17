<?php

/** @var $app \app\core\Application */

use app\controllers\RegisterController;
use app\controllers\SiteController;

// route home page
$app->router->get('/', [SiteController::class, 'home']);
// route register page
$app->router->get('/register', [RegisterController::class, 'index']);
$app->router->post('/register', [RegisterController::class, 'index']);