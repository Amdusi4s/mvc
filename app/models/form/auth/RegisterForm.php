<?php

namespace app\models\form\auth;

use app\core\Application,
    app\core\Html,
    app\models\user\User;

/**
 * Class RegisterForm
 */
class RegisterForm extends User
{
    public string $name = '';
    public string $password = '';
    public string $email = '';
    public string $passwordConfirm = '';

    /**
     * Rules
     * @return array[]
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'name' => [
                self::RULE_REQUIRED,
                [
                    self::RULE_MIN, 'min' => 5
                ],
                [
                    self::RULE_MAX, 'max' => 16
                ]
            ],
            'email' => [
                self::RULE_REQUIRED,
                self::RULE_EMAIL,
                [
                    self::RULE_UNIQUE,
                    'class' => self::class
                ]
            ],
            'password' => [
                self::RULE_REQUIRED,
                [
                    self::RULE_MIN, 'min' => 8
                ]
            ],
            'passwordConfirm' => [
                self::RULE_REQUIRED,
                [
                    self::RULE_MATCH,
                    'match' => 'password'
                ]
            ],
            'captcha' => [
                self::RULE_CAPTCHA
            ]
        ]);
    }

    /**
     * Labels
     * @return string[]
     */
    public function labels(): array
    {
        return array_merge(parent::labels(), [
            'name' => 'Ваше имя',
            'password' => 'Пароль',
            'email' => 'E-mail',
            'passwordConfirm' => 'Повторите пароль'
        ]);
    }

    /**
     * Register
     * @return bool
     */
    public function register(): bool
    {
        $model = new User();
        $model->name = Html::encode($this->name);
        $model->email = Html::encode($this->email);
        $model->password = Application::$app->secure->generatePasswordHash($this->password);

        if ($model->save()) {
            Application::$app->email->send($this->email, 'register', 'register', 'Регистрация', [
                'name' => 1
            ]);

            return true;
        }

        return false;
    }
}