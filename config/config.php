<?php
declare(strict_types=1);

return [
    'db' => [
        // 'host' => '127.0.0.1',
        'host' => 'mysql',
        'dbname' => 'simple_app',
        'user' => 'root',
        // 'password' => ''
        'password' => 'rootpassword'
        
    ],
    'app' => [
        'base_url' => 'http://localhost:8080',
        'hash_salt' => 'some-very-secret-salt-string',
        'timezone' => 'Asia/Dhaka'
    ]
];
