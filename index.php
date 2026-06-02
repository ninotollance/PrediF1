<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

if(session_status() === PHP_SESSION_NONE ) {
    session_name('TestCDA');
    session_start();
}


use Config\Route;

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/route.php';

$route = new Route();
$route->dispatch();
