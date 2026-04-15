<?php
session_start();

use Config\Route;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/route.php';
require_once __DIR__ . '/config/helpers.php';
$route = new Route();
$route->dispatch();