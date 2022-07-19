<?php

namespace app\models\user;

use app\core\UserModel;

/**
 * Class User
 */
class User extends UserModel
{
    public int $id = 0;

    public string $name = '';
    public string $email = '';
    public string $password = '';

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'users';
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return ['name', 'email', 'password'];
    }

    /**
     * @return string[]
     */
    public function labels(): array
    {
        return [
            'name' => 'Ваше имя',
            'email' => 'E-mail',
            'password' => 'Пароль'
        ];
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'name' => [
                self::RULE_REQUIRED
            ],
            'email' => [
                self::RULE_REQUIRED, self::RULE_EMAIL
            ],
            'password' => [
                self::RULE_REQUIRED,
                [
                    self::RULE_MIN, 'min' => 8
                ]
            ]
        ];
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        return parent::save();
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->name;
    }
}