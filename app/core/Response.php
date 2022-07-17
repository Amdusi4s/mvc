<?php

namespace app\core;

/**
 * Class Response
 */
class Response
{
    /**
     * Return status code
     * @param int $code
     */
    public function statusCode(int $code)
    {
        http_response_code($code);
    }

    /**
     * Local redirect
     * @param $url
     */
    public function redirect($url)
    {
        header("Location: $url");
    }
}