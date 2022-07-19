<?php

namespace app\models\form;

use app\core\Application;
use app\core\Model;
use app\models\user\User;

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
        return [
            'name' => [
                self::RULE_REQUIRED
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
            ]
        ];
    }

    /**
     * Labels
     * @return string[]
     */
    public function labels(): array
    {
        return [
            'name' => 'Ваше имя',
            'password' => 'Пароль',
            'email' => 'E-mail',
            'passwordConfirm' => 'Повторите пароль'
        ];
    }

    /**
     * Register
     */
    public function register(): bool
    {
        $model = new User();
        $model->name = $this->name;
        $model->email = $this->email;
        $model->password = Application::$app->secure->generatePasswordHash($this->password);

        if ($model->save()) {
            return true;
        }

        return false;
    }
}