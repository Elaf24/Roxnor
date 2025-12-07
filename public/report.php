<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Bootstrap;
use App\Core\Session;
use App\Controllers\SubmissionController;
use App\Models\User;

Bootstrap::init();

if (!Session::isLoggedIn()) {
    header('Location: /login.php');
    exit;
}

$controller = new SubmissionController();
$submissions = $controller->report();
$userModel = new User();
$users = $userModel->getAllUsers() ?? [];

include __DIR__ . '/../app/Views/report.php';

