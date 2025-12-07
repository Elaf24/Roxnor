<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Bootstrap;
use App\Core\Session;
use App\Controllers\AuthController;

Bootstrap::init();

if (Session::isLoggedIn()) {
    header('Location: /index.php');
    exit;
}

$controller = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'signup') {
        $controller->signup();
    } elseif ($_POST['action'] === 'login') {
        $controller->login();
    }
}

include __DIR__ . '/../app/Views/login.php';

