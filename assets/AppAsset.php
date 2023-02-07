<?php

namespace assets;

use app\core\Application;
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
        '/assets/css/normalize.min.css',
        '/assets/css/style.css'
    ];

    /**
     * Map js files
     * @var array
     */
    public static array $js = [
        '/assets/js/recaptcha.js'
    ];

    /**
     * Run register files
     */
    public static function registerAsset()
    {
        if (Application::$config['components']['captcha']['arguments']['config']['enabled']) {
            self::$js = array_merge(self::$js, [
                'https://www.google.com/recaptcha/api.js',
                '/assets/js/recaptcha.js'
            ]);
        }

        return self::register([
            'css' => self::$css,
            'js' => self::$js
        ]);
    }
}