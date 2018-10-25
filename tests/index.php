<?php

$_SERVER['APPLICATION_ENV'] = 'dev';

date_default_timezone_set('UTC');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL | E_STRICT);

define('ROOT_PATH', __DIR__);
define('APP_PATH', __DIR__ . '/../src/');
define('PROJECT_PATH', __DIR__ . '/../');

set_include_path(
    ROOT_PATH . PATH_SEPARATOR . get_include_path()
);

include PROJECT_PATH . '/vendor/autoload.php';
