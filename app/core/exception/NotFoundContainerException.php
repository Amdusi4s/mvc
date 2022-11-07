<?php

namespace app\core\exception;

use Psr\Container\NotFoundExceptionInterface;
use Exception;

/**
 * Class not found
 */
class NotFoundContainerException extends Exception implements NotFoundExceptionInterface {}