<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\form\LoginForm;

/**
 * Class LoginController
 */
class LoginController extends Controller
{
    /**
     * Login page
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
}