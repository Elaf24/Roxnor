<?php

namespace App\Core;

class Bootstrap
{
    public static function init()
    {
        // Set timezone
        $config = require __DIR__ . '/../../config/app.php';
        date_default_timezone_set($config['timezone']);

        // Start session
        Session::start();
    }
}

