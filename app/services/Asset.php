<?php

namespace app\services;

/**
 * Class Asset
 */
class Asset
{
    /**
     * Register asset files
     */
    public static function register($files)
    {
        $array = [];

        if (count($files['css']) > 0) {
            foreach ($files['css'] as $css) {
                $array[] = self::addCss($css);
            }
        }

        if (count($files['js']) > 0) {
            foreach ($files['js'] as $js) {
                $array[] = self::addJs($js);
            }
        }

        foreach ($array as $file) {
            echo $file;
        }
    }

    /**
     * Return css file
     * @param $path
     * @return string
     */
    public static function addCss($path): string
    {
        return '<link rel="stylesheet" href="'.$path.'">';
    }

    /**
     * Return js file
     * @param $path
     * @return string
     */
    public static function addJs($path): string
    {
        return '<script src="'.$path.'"></script>';
    }
}