<?php

use app\controllers\AccountController;

/** @var \app\core\Application $app */

$app->router->get('/account', [AccountController::class, 'index']);
$app->router->get('/account/edit', [AccountController::class, 'edit']);
$app->router->post('/account/edit', [AccountController::class, 'edit']);