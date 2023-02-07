<?php

namespace app\core\exception;

/**
 * Class NotFoundException
 */
class NotFoundException extends \Exception
{
    /** @var string $message message */
    protected $message = 'Страница не найдена';
    /** @var int $code code */
    protected $code = 404;
}