<?php

namespace app\controllers;

use app\core\Controller;

/**
 * Class RegisterController
 */
class RegisterController extends Controller
{
    /**
     * Home page
     * @return string|string[]
     */
    public function index()
    {
        return $this->render('auth/register', [
            'title' => 'Регистрация'
        ]);
    }
}