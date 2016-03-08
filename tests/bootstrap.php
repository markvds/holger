<?php

require_once __DIR__. "/../vendor/autoload.php";

$credentials = [
    'username' => 'user',
    'password' => 'password'
];

$_ENV['ROUTER_USERNAME'] = 'user';
$_ENV['ROUTER_PASSWORD'] = 'password';
$_ENV['ROUTER_HOST'] = '192.168.178.1';

if (file_exists('config.php')) {
    $loadedCredentials = include 'config.php';

    $_ENV['ROUTER_USERNAME'] = $loadedCredentials['username'];
    $_ENV['ROUTER_PASSWORD'] = $loadedCredentials['password'];
}