<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;

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

        $user = Application::$app->cache->get('homeUser');
        if (!$user) {
            $user = Application::$app->user;
            Application::$app->cache->set('homeUser', $user, 3600 * 24);
        }

        return $this->render('auth/index', [
            'title' => 'Главная страница',
            'user' => $user
        ]);
    }
}