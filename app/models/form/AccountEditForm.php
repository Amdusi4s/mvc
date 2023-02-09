<?php

namespace app\models\form;

use app\core\Application,
    app\core\Html,
    app\core\Model,
    app\models\user\User;

/**
 * Class AccountEditForm
 */
class AccountEditForm extends Model
{
    public string $name = '';
    public string $email = '';

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
                self::RULE_REQUIRED
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
            'name' => 'Имя'
        ]);
    }

    /**
     * Return array attributes model
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name', 'email'
        ];
    }

    /**
     * Edit account
     * @return bool
     */
    public function edit(): bool
    {
        $model = new User();
        $model->name = Html::encode($this->name);
        $model->email = Html::encode($this->email);

        if ($model->update($this->attributes(), [Application::$app->userClass::primaryKey() => Application::$app->userId])) {
            Application::$app->cache->delete('user');

            return true;
        }

        return false;
    }
}