<?php

use app\controllers\CaptchaController,
    app\controllers\SiteController;

/** @var \app\core\Application $app */

// route home page
$app->router->get('/', [SiteController::class, 'home']);
// route captcha
$app->router->get('/captcha', [CaptchaController::class, 'generate']);