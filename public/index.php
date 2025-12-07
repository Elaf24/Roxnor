<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Bootstrap;
use App\Core\Session;
use App\Controllers\SubmissionController;

Bootstrap::init();

if (!Session::isLoggedIn()) {
    header('Location: /login.php');
    exit;
}

$controller = new SubmissionController();
$controller->index();

include __DIR__ . '/../app/Views/submission_form.php';

