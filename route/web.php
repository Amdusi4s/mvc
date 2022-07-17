<?php

/** @var $app \app\core\Application */

use app\controllers\RegisterController;
use app\controllers\SiteController;

$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/register', [RegisterController::class, 'index']);