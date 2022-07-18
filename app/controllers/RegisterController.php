<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\form\RegisterForm;

/**
 * Class RegisterController
 */
class RegisterController extends Controller
{
    /**
     * Register page
     * @return string|string[]
     */
    public function index(Request $request)
    {
        $model = new RegisterForm();

        if ($request->getMethod() === 'post') {
            $model->loadData($request->getBody());
            if ($model->validate()) {
                if ($model->register()) {
                    Application::$app->session->setFlash('success', 'Спасибо за регистрацию. Мы можете авторизоваться');
                } else {
                    Application::$app->session->setFlash('error', 'Произошла ошибка при регистрации');
                }
            }
        }

        return $this->render('auth/register', [
            'title' => 'Регистрация',
            'model' => $model
        ]);
    }
}