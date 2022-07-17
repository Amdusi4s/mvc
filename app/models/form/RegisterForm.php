<?php

namespace app\models\form;

use app\core\Model;

/**
 * Class RegisterForm
 */
class RegisterForm extends Model
{
    public string $name = '';
    public string $password = '';
    public string $email = '';

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
            'name' => 'Ваше имя',
            'password' => 'Пароль',
            'email' => 'E-mail'
        ];
    }

    /**
     * Register
     */
    public function register(): string
    {
        return 'Сообщение об успешной регистрации';
    }
}