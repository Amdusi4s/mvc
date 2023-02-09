<?php

namespace app\controllers;

use app\core\Application,
    app\core\Controller;

/**
 * Class CaptchaController
 */
class CaptchaController extends Controller
{
    /**
     * Generate default captcha
     * @return mixed
     */
    public function generate()
    {
        return Application::$app->captcha->generate();
    }
}