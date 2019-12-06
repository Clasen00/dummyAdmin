<?php
session_start();

define('ROOT', dirname(__DIR__));
define('PROJECT', dirname(__DIR__) . '/dummyAdmin');
define('APP', dirname(__DIR__) . '/dummyAdmin/app');
//define('FILES', 'http://dummyadmin/files/images');
define('FILES', dirname(__DIR__) . '/files/images');

require_once __DIR__ . '/app/helpers.php';
require __DIR__ . '/vendor/autoload.php';

use app\core\App;

$app = new App();
$app->dispatch();
