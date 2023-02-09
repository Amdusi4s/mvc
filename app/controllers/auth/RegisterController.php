<?php

namespace app\controllers\auth;

use app\core\Application,
    app\core\Controller,
    app\core\Request,
    app\models\form\auth\RegisterForm,
    app\core\exception\ForbiddenException;

/**
 * Class RegisterController
 */
class RegisterController extends Controller
{
    /**
     * Register page
     * @return string|string[]
     * @throws \app\core\exception\InvalidCsrfTokenException|ForbiddenException
     */
    public function index(Request $request): array|string
    {
        if (!Application::isGuest()) {
            throw new ForbiddenException();
        }

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