<?php

namespace app\core;

/**
 * Class Config
 */
class Config extends Application
{
    /**
     * Load configs
     */
    public static function loadConfig()
    {
        self::$config = require_once __DIR__. '/../../config/app.php';

        return self::$config;
    }

    /**
     * Return config
     * @param string $config
     * @return mixed
     */
    public static function getConfig(string $config): mixed
    {
        return self::$config[$config];
    }
}