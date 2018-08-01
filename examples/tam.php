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

try {
    dump($holger->answeringMachine->getInfo());
    dump($holger->answeringMachine->getMessageListUrl());
    $messages = $holger->answeringMachine->getMessageList();
    if (count($messages) > 0) {
        $message = $messages[0];
        dump($message->path);

        $message->download('call-' . $message->caller . '.wav');
    }
} catch (Exception $e) {
    dump($e);
}
