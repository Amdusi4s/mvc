<?php

namespace app\core\db;

use app\core\Application,
    app\core\Model;

/**
 * Class DbModel
 */
abstract class DbModel extends Model
{
    abstract public static function tableName(): string;

    public static function primaryKey(): string
    {
        return 'id';
    }

    /**
     * Return query
     * @param $sql
     * @param array $params
     * @return bool
     */
    public static function query($sql, array $params = []): bool
    {
        return Application::$app->db->query($sql, $params);
    }

    /**
     * Return row object
     * @param $sql
     * @param array $params
     * @param $class
     * @return object|bool
     */
    public static function getRowObject($sql, array $params, $class): object|bool
    {
        return Application::$app->db->getRowObject($sql, $params, $class);
    }

    /**
     * Save in table
     * @return bool
     */
    public function save(): bool
    {
        $tableName = $this->tableName();

        $setAttributes = [];
        $valueAttributes = [];
        $attributes = $this->attributes();

        foreach ($attributes as $attribute) {
            $setAttributes[] = "`{$attribute}` = ?";
            $valueAttributes[] = $this->{$attribute};
        }

        $sql = "INSERT INTO `{$tableName}` SET ".(implode(",", $setAttributes))." ";
        return self::query($sql, $valueAttributes);
    }

    /**
     * Find row in table
     * @param array $where
     * @return object|bool
     */
    public static function findOne(array $where): object|bool
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND", array_map(fn($attr) => "`{$attr}` = :$attr", $attributes));
        $sql = "SELECT * FROM `{$tableName}` WHERE $sql";
        return self::getRowObject($sql, $where, static::class);
    }

    /**
     * Update row in table
     * @param array $attributes
     * @param array $where
     * @return bool
     */
    public function update(array $attributes, array $where): bool
    {
        $tableName = $this->tableName();

        $setAttributes = $valueAttributes = [];

        if (count($attributes) === 0) {
            $attributes = $this->attributes();
        }

        foreach ($attributes as $attribute) {
            $setAttributes[] = "`{$attribute}` = ?";
            $valueAttributes[] = $this->{$attribute};
        }

        $where = array_keys($where);
        $sql = implode("AND", array_map(fn($attr) => "`{$attr}` = $attr", $where));

        $sql = "UPDATE `{$tableName}` SET ".(implode(",", $setAttributes))."  WHERE $sql";

        return self::query($sql, $valueAttributes);
    }
}