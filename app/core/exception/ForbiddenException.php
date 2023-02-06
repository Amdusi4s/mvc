<?php

namespace app\core\exception;

/**
 * Class ForbiddenException
 */
class ForbiddenException extends \Exception
{
    /** @var string $message message */
    protected $message = 'You do not have permission to access this page';

    /** @var int $code code */
    protected $code = 403;
}