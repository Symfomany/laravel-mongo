<?php
return [
    'connections' => [
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'cineacademy',
            'username'  => 'root',
            'password'  => 'djscrave',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],
        'mongodb' => [
            'name'       => 'mongodb',
            'driver'     => 'mongodb',
            'host'       => '127.0.0.1',
            'database'   => 'testing',
        ],
    ],
];