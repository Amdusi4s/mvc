<?php

namespace app\controllers;

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
                return $model->register();
            }
        }

        return $this->render('auth/register', [
            'title' => 'Регистрация',
            'model' => $model
        ]);
    }
}