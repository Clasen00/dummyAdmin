<?php

define('ROOT', dirname(__DIR__));

require_once __DIR__ . '/app/helpers.php';
require __DIR__ . '/vendor/autoload.php';

use app\core\App;

$app = new App();
$app->dispatch();
