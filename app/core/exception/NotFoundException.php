<?php

namespace app\core\exception;

/**
 * Class NotFoundException
 */
class NotFoundException extends \Exception
{
    /**
     * Message
     * @var string
     */
    protected $message = 'Page not found';
    /**
     * Code
     * @var int
     */
    protected $code = 404;
}