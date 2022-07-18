<?php

namespace app\core\db;

use PDO;
use PDOException;

/**
 * Class Database
 */
class Database
{
    /**
     * Object PDO
     * @var PDO|null
     */
    public static ?PDO $pdo = null;
    /**
     * Statement Handle
     */
    public static $handle = null;

    /**
     * Constructor
     * @param array $dbConfig
     */
    public function __construct(array $dbConfig = [])
    {
        if (!self::$pdo) {
            try {
                $dbDsn = $dbConfig['dsn'] ?? '';
                $username = $dbConfig['user'] ?? '';
                $password = $dbConfig['password'] ?? '';

                $options = [
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => true
                ];

                self::$pdo = new PDO(
                    $dbDsn,
                    $username,
                    $password,
                    $options
                );
            } catch (PDOException $e) {
                exit('Error connecting to database: ' . $e->getMessage());
            }
        }

        return self::$pdo;
    }

    /**
     * Close connection
     */
    public static function destroy(): ?PDO
    {
        self::$pdo = null;
        return self::$pdo;
    }

    /**
     * Return error query
     */
    public static function getError(): ?string
    {
        $info = self::$handle->errorInfo();
        return (isset($info[2])) ? 'SQL: ' . $info[2] : null;
    }

    /**
     * Returns the table structure as an associative array
     */
    public static function getStructure($table): array
    {
        $res = [];
        foreach (self::getAll("SHOW COLUMNS FROM {$table}") as $row) {
            $res[$row['Field']] = (is_null($row['Default'])) ? '' : $row['Default'];
        }

        return $res;
    }

    /**
     * Adding to the table will return the inserted ID if successful, otherwise 0
     */
    public static function add($query, $param = []): int|string
    {
        self::$handle = self::$pdo->prepare($query);
        return (self::$handle->execute((array) $param)) ? self::$pdo->lastInsertId() : 0;
    }

    /**
     * Return query
     */
    public static function query($query, $param = []): bool
    {
        self::$handle = self::$pdo->prepare($query);
        return self::$handle->execute((array) $param);
    }

    /**
     * Return row from table
     */
    public static function getRow($query, $param = [])
    {
        self::$handle = self::$pdo->prepare($query);
        self::$handle->execute((array) $param);
        return self::$handle->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Return row from table
     */
    public static function getRowObject($query, $param, $class)
    {
        self::$handle = self::$pdo->prepare($query);
        self::$handle->execute((array) $param);
        return self::$handle->fetchObject($class);
    }

    /**
     * Return all row from table
     */
    public static function getAll($query, $param = []): bool|array
    {
        self::$handle = self::$pdo->prepare($query);
        self::$handle->execute((array) $param);
        return self::$handle->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Return value
     */
    public static function getValue($query, $param = [], $default = null)
    {
        $result = self::getRow($query, $param);
        if (!empty($result)) {
            $result = array_shift($result);
        }

        return (empty($result)) ? $default : $result;
    }

    /**
     * Return column table
     */
    public static function getColumn($query, $param = []): bool|array
    {
        self::$handle = self::$pdo->prepare($query);
        self::$handle->execute((array) $param);
        return self::$handle->fetchAll(PDO::FETCH_COLUMN);
    }
}