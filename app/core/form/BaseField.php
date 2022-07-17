<?php

namespace app\core\form;

use app\core\Model;

/**
 * Class BaseField
 */
abstract class BaseField
{
    /**
     * Object class Model
     * @var Model
     */
    public Model $model;
    /**
     * Attribute
     * @var string
     */
    public string $attribute;
    /**
     * Type
     * @var string
     */
    public string $type;

    /**
     * Constructor
     * @param Model $model
     * @param string $attribute
     */
    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }

    /**
     * Render input
     * @return mixed
     */
    abstract public function renderInput();

    /**
     * Render input
     * @return string
     */
    public function __toString()
    {
        return sprintf('<div class="form-group">
                <label><strong>%s</strong></label>
                %s
                <div class="invalid-feedback">
                    %s
                </div>
            </div>',
            $this->model->getLabel($this->attribute),
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)
        );
    }
}