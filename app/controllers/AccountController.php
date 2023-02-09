<?php

namespace app\controllers;

use app\core\Application,
    app\core\Controller,
    app\core\exception\InvalidCsrfTokenException,
    app\core\Request,
    app\models\form\AccountEditForm,
    app\core\middlewares\AuthMiddleware;

/**
 * Class AccountController
 */
class AccountController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['index', 'edit']));
    }

    /**
     * Account page
     * @return string|string[]
     */
    public function index(): array|string
    {
        return $this->render('account/index', [
            'title' => 'Личный кабинет',
            'user' => Application::$app->user
        ]);
    }

    /**
     * Account edit page
     * @return string|string[]
     * @throws InvalidCsrfTokenException
     */
    public function edit(Request $request): array|string
    {
        $model = new AccountEditForm();
        $user = Application::$app->user;

        $model->name = $user->name;
        $model->email = $user->email;

        if ($request->getMethod() === 'post') {
            $model->loadData($request->getBody());

            if ($model->validate()) {
                if ($model->edit()) {
                    Application::$app->session->setFlash('success', 'Вы успешно отредактировали аккаунт');
                } else {
                    Application::$app->session->setFlash('error', 'Произошла ошибка при редактировании аккаунта');
                }

                return Application::$app->response->redirect('/account');
            }
        }

        return $this->render('account/edit', [
            'title' => 'Редактирование',
            'user' => $user,
            'model' => $model
        ]);
    }
}