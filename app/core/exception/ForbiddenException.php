<?php

namespace app\core\exception;

/**
 * Class ForbiddenException
 */
class ForbiddenException extends \Exception
{
    /** @var string $message message */
    protected $message = 'У вас нет разрешения на доступ к этой странице';
    /** @var int $code code */
    protected $code = 403;
}