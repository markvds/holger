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

$phone = $holger->voip->callingPhone();

echo "Calling from {$phone}....\n";

// Initialize a call via the call assistance feature ("Wählhilfe") from the
// phone, you selected in the config. Use it to call internal phones.
// This will start a call to all phones and hang up after 3 seconds.
// You can replace it with any internal or external phone number.
$holger->voip->call("**9");
sleep(3);
$holger->voip->hangup();
