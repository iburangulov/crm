<?php

use App\Application;

define('ROOT_DIR', $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR);

require_once ROOT_DIR . 'vendor/autoload.php';

$app = new Application();

$app->init();

$app->start();

$app->finish();