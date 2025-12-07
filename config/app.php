<?php

return [
    'app_name' => 'Roxnor',
    'base_url' => getenv('BASE_URL') ?: 'http://localhost',
    'timezone' => 'Asia/Dhaka',
    'session_name' => 'roxnor_session',
    'hash_salt' => getenv('HASH_SALT') ?: 'roxnor_salt_key_2024'
];

