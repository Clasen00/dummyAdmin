<?php

require_once __DIR__ . '/app/helpers.php';
require __DIR__ . '/vendor/autoload.php';

use app\core\App;

try {

    $app = new App();
    $app->dispatch();
} catch (Exception $exc) {
    echo $exc->getTraceAsString();
}