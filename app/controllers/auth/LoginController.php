<?php

namespace app\controllers\auth;

use app\core\Application,
    app\core\Controller,
    app\core\middlewares\AuthMiddleware,
    app\core\Request,
    app\core\Response,
    app\models\form\auth\LoginForm,
    app\core\exception\ForbiddenException;

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
        $this->registerMiddleware(new AuthMiddleware(['logout']));
    }

    /**
     * Login page
     * @return string|string[]
     * @throws \app\core\exception\InvalidCsrfTokenException|ForbiddenException
     */
    public function index(Request $request): array|string
    {
        if (!Application::isGuest()) {
            throw new ForbiddenException();
        }

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