<?php

namespace app\core\exception;

/**
 * Class NotFoundException
 */
class NotFoundException extends \Exception
{
    /** @var string $message message */
    protected $message = 'Page not found';

    /** @var int $code code */
    protected $code = 404;
}