<?php

// Doctrine (db)
$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'charset'  => 'utf8',
    'host'     => '127.0.0.1',  // Mandatory for PHPUnit testing
    'port'     => '3306',
    'dbname'   => 'blog_ecrivain',
    'user'     => 'Forteroche',
    'password' => 'Alaska',
);

// enable the debug mode
$app['debug'] = true;