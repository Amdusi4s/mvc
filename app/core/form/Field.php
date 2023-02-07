<?php

namespace app\core\form;

use app\core\Application;
use app\core\Model;

/**
 * Class Field
 */
class Field extends BaseField
{
    const TYPE_TEXT = 'text';
    const TYPE_PASSWORD = 'password';
    const TYPE_EMAIL = 'email';
    const TYPE_HIDDEN = 'hidden';

    /**
     * Constructor
     * @param Model $model
     * @param string $attribute
     */
    public function __construct(Model $model, string $attribute)
    {
        $this->type = self::TYPE_TEXT;
        parent::__construct($model, $attribute);
    }

    /**
     * Render input
     * @return mixed
     */
    public function renderInput(): mixed
    {
        $captcha = '';

        if ($this->attribute === 'captcha') {
            $captcha = Application::$app->captcha->show();
        }

        $input = sprintf('<input type="%s" class="form-control%s" name="%s" value="%s">%s',
            $this->type,
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->attribute,
            $this->model->{$this->attribute},
            $captcha
        );

        return $input;
    }

    /**
     * Change type password field
     * @return $this
     */
    public function passwordField(): static
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    /**
     * Change type email field
     */
    public function emailField(): static
    {
        $this->type = self::TYPE_EMAIL;
        return $this;
    }

    /**
     * Change type captcha field
     */
    public function captchaField()
    {
        $this->type = Application::$app->captcha->config['type'] === 'recaptcha' ? self::TYPE_HIDDEN : self::TYPE_TEXT;
        return $this;
    }

    /**
     * Change type hidden field
     */
    public function hiddenField(): static
    {
        $this->type = self::TYPE_HIDDEN;
        return $this;
    }
}