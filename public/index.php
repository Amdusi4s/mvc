<?php

declare(strict_types=1);

use app\core\Application;
use app\core\Config;

// include composer
require_once __DIR__ . '/../vendor/autoload.php';

$config = Config::loadConfig();
$app = new Application(dirname(__DIR__), $config);

// include routes
require_once Application::$rootDir . '/route/web.php';

// run application
$app->run();