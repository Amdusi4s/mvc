<?php

namespace app\core\exception;

/**
 * Class EmailException
 */
class EmailException extends \Exception
{
    /**
     * Message
     * @var string
     */
    protected $message = 'Error send email';
    /**
     * Code
     * @var int
     */
    protected $code = 0;
}