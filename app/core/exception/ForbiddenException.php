<?php

namespace app\core\exception;

/**
 * Class ForbiddenException
 */
class ForbiddenException extends \Exception
{
    /**
     * Message
     * @var string
     */
    protected $message = 'У вас нет разрешения на доступ к этой странице';
    /**
     * Code
     * @var int
     */
    protected $code = 403;
}