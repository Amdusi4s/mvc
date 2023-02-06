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
     * @return int|bool
     */
    public function statusCode(int $code): int|bool
    {
        http_response_code($code);
    }

    /**
     * Local redirect
     * @param $url
     * @return void
     */
    public function redirect($url): void
    {
        header("Location: $url");
    }
}