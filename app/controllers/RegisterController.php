<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\models\form\RegisterForm;

/**
 * Class RegisterController
 */
class RegisterController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['index']));
    }

    /**
     * Register page
     * @return string|string[]
     * @throws \app\core\exception\InvalidCsrfTokenException
     */
    public function index(Request $request): array|string
    {
        $model = new RegisterForm();

        if ($request->getMethod() === 'post') {
            $model->loadData($request->getBody());
            if ($model->validate()) {
                if ($model->register()) {
                    Application::$app->session->setFlash('success', 'Спасибо за регистрацию. Вы можете авторизоваться');
                } else {
                    Application::$app->session->setFlash('error', 'Произошла ошибка при регистрации');
                }

                Application::$app->response->redirect('/login');
            }
        }

        return $this->render('auth/register', [
            'title' => 'Регистрация',
            'model' => $model
        ]);
    }
}