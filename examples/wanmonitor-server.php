<?php

use Holger\Holger;

require_once '../vendor/autoload.php';

$credentials = [
    'username' => 'user',
    'password' => 'password',
];

if (file_exists('../config.php')) {
    $loadedCredentials = include '../config.php';

    $credentials = array_merge($credentials, $loadedCredentials);
}

$holger = new Holger('192.168.178.1', $credentials['password'], $credentials['username']);

$stats = $holger->monitor->getOnlineMonitor();

header("Content-Type: application/json");

echo json_encode($stats);