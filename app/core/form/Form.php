<?php

namespace app\core\form;

use app\core\Application,
    app\core\Model;

/**
 * Class Form
 */
class Form
{
    /**
     * Render begin form
     * @param $action
     * @param $method
     * @param array $options
     * @return Form
     */
    public static function begin($action, $method, array $options = []): Form
    {
        $attributes = [];
        foreach ($options as $key => $value) {
            $attributes[] = "$key=\"$value\"";
        }
        echo sprintf('<form action="%s" method="%s" %s>', $action, $method, implode(" ", $attributes));
        return new Form();
    }

    /**
     * Render end form
     * @throws \Exception
     * @return void
     */
    public static function end(): void
    {
        echo '<input type="hidden" name="token" value="' . Application::$app->csrf->generate() . '"></form>';
    }

    /**
     * Render field
     * @param Model $model
     * @param $attribute
     * @return Field
     */
    public function field(Model $model, $attribute): Field
    {
        return new Field($model, $attribute);
    }
}