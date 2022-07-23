<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\form\LoginForm;

/**
 * Class LoginController
 */
class LoginController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['index']));
    }

    /**
     * Login page
     * @throws \app\core\exception\InvalidCsrfTokenException
     */
    public function index(Request $request): array|string
    {
        $model = new LoginForm();

        if ($request->getMethod() === 'post') {
            $model->loadData($request->getBody());

            if ($model->validate()) {
                if ($model->login()) {
                    Application::$app->session->setFlash('success', 'Вы успешно авторизовались');
                    Application::$app->response->redirect('/');
                } else {
                    Application::$app->session->setFlash('error', 'Такого пользователя не существует');
                    Application::$app->response->redirect('/login');
                }
            }
        }

        return $this->render('auth/login', [
            'title' => 'Авторизация',
            'model' => $model
        ]);
    }

    /**
     * Logout
     */
    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }
}