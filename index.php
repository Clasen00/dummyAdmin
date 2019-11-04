<?php

define('ROOT', dirname(__DIR__));
define('PROJECT', dirname(__DIR__) . '/dummyAdmin');

require_once __DIR__ . '/app/helpers.php';
require __DIR__ . '/vendor/autoload.php';

use app\core\App;

$app = new App();
$app->dispatch();
