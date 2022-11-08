<?php

namespace app\core\container\exception;

use Exception;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class not found
 */
class NotFoundException extends Exception implements NotFoundExceptionInterface {}