<?php

require_once "vendor/autoload.php";

$credentials = [
    'username' => 'user',
    'password' => 'password'
];

if (file_exists('config.php')) {
    $loadedCredentials = include 'config.php';

    $credentials = array_merge($credentials, $loadedCredentials);
}

$res = new Holger\TR064Connection('192.168.178.1', $credentials['password'], $credentials['username']);

$dect = new \Holger\DECTInfo($res);

var_dump($dect->getHandsets());

$wanip = new \Holger\WANIP($res);

var_dump($wanip->externalIP());
