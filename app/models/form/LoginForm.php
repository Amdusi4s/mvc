<?php

namespace app\models\form;

use app\core\Application,
    app\core\Html,
    app\core\Model,
    app\models\user\User;

/**
 * Class LoginForm
 */
class LoginForm extends Model
{
    public string $email = '';
    public string $password = '';
    public string $token = '';

    /**
     * Rules
     * @return array[]
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'email' => [
                self::RULE_REQUIRED
            ],
            'password' => [
                self::RULE_REQUIRED
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
            'email' => 'E-mail',
            'password' => 'Пароль'
        ]);
    }

    /**
     * Login
     * @return bool|false
     */
    public function login(): bool
    {
        $user = User::findOne(['email' => Html::encode($this->email)]);

        if (!$user || !$this->password_verify($this->password, $user->password)) {
            return false;
        }

        return Application::$app->login($user);
    }

    /**
     * Validate password
     * @param $password
     * @param $hash
     * @return bool
     */
    private function password_verify($password, $hash): bool
    {
        return Application::$app->secure->validatePassword($password, $hash);
    }
}