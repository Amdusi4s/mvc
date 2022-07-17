<?php


namespace app\core;

/**
 * Class Model
 *
 * @package app\core
 */
abstract class Model
{
    const RULE_REQUIRED = 'required';
    const RULE_EMAIL = 'email';
    const RULE_MIN = 'min';
    const RULE_MAX = 'max';
    const RULE_MATCH = 'match';
    const RULE_UNIQUE = 'unique';

    public array $errors = [];

    /**
     * Метод загрузки данных которые пришли от пользователя
     *
     * @param $data
     */
    public function loadData(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * Метод возвращает массив атрибутов
     *
     * @return array
     */
    public function attributes()
    {
        return [];
    }

    /**
     * Метод возвращает массив атрибута label
     *
     * @return array
     */
    public function labels()
    {
        return [];
    }

    /**
     * Массив возвращает значение массива атрибута label
     *
     * @param $attribute
     * @return mixed
     */
    public function getLabel(string $attribute)
    {
        return $this->labels()[$attribute] ?? $attribute;
    }


    /**
     * Метод правил валидации модели
     *
     * @return mixed
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Метод валидации модели
     */
    public function validate()
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
     * Метод добавляет ошибку валидации
     *
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
     * Метод выводит сообщение ошибки валидаци
     *
     * @return array
     */
    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'Поле {field} обязательно к заполнению',
            self::RULE_EMAIL => 'Поле {field} должно иметь валидный email адрес',
            self::RULE_MIN => 'Минимальное количество символов в поле {field} должно быть {min}',
            self::RULE_MAX => 'Максимальное количество символов в поле {field} должно быть {max}',
            self::RULE_MATCH => 'Поле {field} должно совпадать со значением поля {match}'
        ];
    }

    /**
     * Метод проверяет наличие ошибок валидации
     *
     * @param $attribute
     * @return false|mixed
     */
    public function hasError(string $attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    /**
     * Метод возвращает текущую ошибку валидации
     *
     * @param $attribute
     * @return false|mixed
     */
    public function getFirstError(string $attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
}