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

$numbers = [
    new \Holger\Entities\PhoneNumber('01234567890', 0, \Holger\Entities\PhoneNumber::TYPE_MOBILE, 1),
    \Holger\Entities\PhoneNumber::newHome('01012345', 1, 0),
];

$entry = \Holger\Entities\PhonebookEntry::create('Name', $numbers, 'test@mail.com');
$holger->phonebook->addPhonebookEntry(0, $entry);
