<?php

namespace app\core\captcha\exception;

use Exception,
    Psr\Container\NotFoundExceptionInterface;

/**
 * Class not found
 */
class CaptchaException extends Exception implements NotFoundExceptionInterface {}