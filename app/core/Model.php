<?php

namespace app\core;

/**
 * Class Model
 */
class Model
{
    const RULE_REQUIRED = 'required';
    const RULE_EMAIL = 'email';
    const RULE_MIN = 'min';
    const RULE_MAX = 'max';
    const RULE_MATCH = 'match';

    /**
     * Errors
     * @var array
     */
    public array $errors = [];

    /**
     * Loading data that came from the user
     * @param $data
     */
    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * Return array attributes model
     * @return array
     */
    public function attributes(): array
    {
        return [];
    }

    /**
     * Return array labels model
     * @return array
     */
    public function labels(): array
    {
        return [];
    }

    /**
     * Return label
     * @param $attribute
     * @return mixed
     */
    public function getLabel($attribute): mixed
    {
        $labels = $this->labels();
        return $labels[$attribute] ?? $attribute;
    }

    /**
     * Return rules model
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Return messages validate
     * @return array
     */
    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'Поле {field} обязательно к заполнению',
            self::RULE_EMAIL => 'Поле {field} должно иметь валидный email адрес',
            self::RULE_MIN => 'Минимальное количество символов в поле {field} должно быть {min}',
            self::RULE_MAX => 'Максимальное количество символов в поле {field} должно быть {max}'
        ];
    }

    /**
     * Add error rule
     * @param string $attribute
     * @param string $rule
     * @param array $params
     */
    public function addError(string $attribute, string $rule, array $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $message = str_replace("{field}", $this->getLabel($attribute), $message);
        $this->errors[$attribute][] = $message;
    }

    /**
     * Validate model
     * @return bool
     */
    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addError($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && mb_strlen($value) < $rule['min']) {
                    $this->addError($attribute, self::RULE_MIN, $rule);
                }
                if ($ruleName === self::RULE_MAX && mb_strlen($value) > $rule['max']) {
                    $this->addError($attribute, self::RULE_MAX, $rule);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addError($attribute, self::RULE_MATCH, $rule);
                }
            }
        }

        return empty($this->errors);
    }

    /**
     * Isset error rule validate
     * @param string $attribute
     * @return mixed
     */
    public function hasError(string $attribute): mixed
    {
        return $this->errors[$attribute] ?? false;
    }

    /**
     * Current error rule validate
     * @param string $attribute
     * @return mixed
     */
    public function getFirstError(string $attribute): mixed
    {
        return $this->errors[$attribute][0] ?? false;
    }
}