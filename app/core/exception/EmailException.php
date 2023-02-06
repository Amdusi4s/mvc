<?php

namespace app\core\exception;

/**
 * Class EmailException
 */
class EmailException extends \Exception
{
    /** @var string $message message */
    protected $message = 'Error send email';

    /** @var int $code code */
    protected $code = 0;
}