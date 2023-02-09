<?php

namespace app\controllers;

use app\core\Application,
    app\core\Controller,
    app\core\middlewares\AuthMiddleware;

/**
 * Class SiteController
 */
class SiteController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['account']));
    }

    /**
     * Home page
     * @return string|string[]
     */
    public function home(): array|string
    {
        if (Application::isGuest()) {
            return $this->render('home');
        }

        return $this->render('auth/index', [
            'title' => 'Главная страница',
            'user' => Application::$app->user
        ]);
    }
}