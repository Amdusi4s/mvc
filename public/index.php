<?php

declare(strict_types=1);

use app\core\Application,
    app\core\Config;

// include composer
require_once __DIR__ . '/../vendor/autoload.php';

// load configs
$config = Config::loadConfig();
$app = new Application(dirname(__DIR__), $config);
// run application
$app->run($app);