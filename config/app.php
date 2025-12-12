<?php

return [
    'app_name' => 'Roxnor',
    'app_env' => getenv('APP_ENV') ?: 'production',
    'app_debug' => filter_var(getenv('APP_DEBUG'), FILTER_VALIDATE_BOOLEAN),
    'base_url' => getenv('BASE_URL') ?: 'http://localhost',
    'timezone' => 'Asia/Dhaka',
    'session_name' => 'roxnor_session',
    'session_lifetime' => (int)(getenv('SESSION_LIFETIME') ?: 120),
    'hash_salt' => getenv('HASH_SALT') ?: throw new Exception('HASH_SALT environment variable is not set')
];

