<?php

namespace app\models\form;

use app\core\Application;
use app\core\Model;
use app\models\user\User;

/**
 * Class LoginForm
 */
class LoginForm extends Model
{
    public string $email = '';
    public string $password = '';

    /**
     * Rules
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'email' => [
                self::RULE_REQUIRED
            ],
            'password' => [
                self::RULE_REQUIRED
            ],
        ];
    }

    /**
     * Labels
     * @return string[]
     */
    public function labels(): array
    {
        return [
            'email' => 'E-mail',
            'password' => 'Пароль'
        ];
    }

    /**
     * Login
     * @return bool|false
     */
    public function login(): bool
    {
        $user = User::findOne(['email' => $this->email]);
        if (!$user || !password_verify($this->password, $user->password)) {
            return false;
        }

        return Application::$app->login($user);
    }
}