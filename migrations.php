<?php

declare(strict_types=1);

use app\core\Application;
use app\core\Config;

// include composer
require_once __DIR__ . '/vendor/autoload.php';

$config = Config::loadConfig();
$application = new Application(__DIR__, $config);

// start migrations
$application::$app->db->migrations();