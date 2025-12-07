<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Bootstrap;
use App\Core\Session;
use App\Controllers\SubmissionController;

Bootstrap::init();
$controller = new SubmissionController();
$controller->create();

