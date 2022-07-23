<?php

namespace app\models\form;

use app\core\Application;
use app\core\Html;
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
        return array_merge(parent::rules(), [
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
     */
    public function register(): bool
    {
        $model = new User();
        $model->name = Html::encode($this->name);
        $model->email = Html::encode($this->email);
        $model->password = Application::$app->secure->generatePasswordHash($this->password);

        if ($model->save()) {
            return true;
        }

        return false;
    }
}