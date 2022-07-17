<?php

namespace app\core\form;

use app\core\Model;

/**
 * Class Field
 */
class Field extends BaseField
{
    /**
     * Type text
     */
    const TYPE_TEXT = 'text';
    /**
     * Type password
     */
    const TYPE_PASSWORD = 'password';

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
        return sprintf('<input type="%s" class="form-control%s" name="%s" value="%s">',
            $this->type,
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->attribute,
            $this->model->{$this->attribute},
        );
    }

    /**
     * Return type password field
     * @return $this
     */
    public function passwordField(): static
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }
}