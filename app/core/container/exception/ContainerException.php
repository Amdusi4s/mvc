<?php

namespace app\core\container\exception;

use Exception,
    Psr\Container\ContainerExceptionInterface;

/**
 * Class could not be instantiated
 */
class ContainerException extends Exception implements ContainerExceptionInterface {}