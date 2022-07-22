<?php

namespace app\core;

/**
 * Class Html
 */
class Html
{
    /**
     * Encodes special characters into HTML entities
     * @param $content
     * @param bool $doubleEncode
     * @return string
     */
    public static function encode($content, bool $doubleEncode = true): string
    {
        return htmlspecialchars((string)$content, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8', $doubleEncode);
    }

    /**
     * Decodes special HTML entities back to the corresponding characters
     * @param $content
     * @return string
     */
    public static function decode($content): string
    {
        return htmlspecialchars_decode($content, ENT_QUOTES);
    }
}