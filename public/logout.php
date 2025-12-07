<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Bootstrap;
use App\Core\Session;
use App\Controllers\AuthController;

Bootstrap::init();
$controller = new AuthController();
$controller->logout();

