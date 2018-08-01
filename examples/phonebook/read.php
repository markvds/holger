<?php

require_once '../../vendor/autoload.php';

$credentials = [
    'username' => 'user',
    'password' => 'password',
];

if (file_exists('../../config.php')) {
    $loadedCredentials = include '../../config.php';

    $credentials = array_merge($credentials, $loadedCredentials);
}

$holger = new Holger\Holger('192.168.178.1', $credentials['password'], $credentials['username']);

$id = 0;
if (count($argv) > 1) {
    $id = $argv[1];
}

dump($holger->phonebook->entry($id, 0));
