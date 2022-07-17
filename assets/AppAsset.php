<?php

namespace assets;

use app\services\Asset;

/**
 * Class AppAsset
 */
class AppAsset extends Asset
{
    /**
     * Map css files
     * @var array|string[]
     */
    public static array $css = [
        'css/normalize.min.css',
        'css/style.css'
    ];

    /**
     * Map js files
     * @var array
     */
    public static array $js = [];

    /**
     * Run register files
     */
    public static function registerAsset()
    {
        return self::register([
            'css' => self::$css,
            'js' => self::$js
        ]);
    }
}