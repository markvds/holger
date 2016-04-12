<?php

require_once '../vendor/autoload.php';

$credentials = [
    'username' => 'user',
    'password' => 'password',
];

if (file_exists('../config.php')) {
    $loadedCredentials = include '../config.php';

    $credentials = array_merge($credentials, $loadedCredentials);
}

$res = new Holger\TR064Connection('192.168.178.1', $credentials['password'], $credentials['username']);

$tam = new \Holger\AnsweringMachine($res);

try {
    dump($tam->getInfo());
    dump($tam->getMessageListUrl());
    $deviceConfig = new \Holger\DeviceConfig($res);
    dump($tam->getMessageList(0, $deviceConfig->getSid()));
} catch (Exception $e) {
    dump($e);
}
