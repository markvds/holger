<?php

require_once "../../vendor/autoload.php";

$credentials = [
    'username' => 'user',
    'password' => 'password'
];

if (file_exists('../../config.php')) {
    $loadedCredentials = include '../../config.php';

    $credentials = array_merge($credentials, $loadedCredentials);
}

$res = new Holger\TR064Connection('192.168.178.1', $credentials['password'], $credentials['username']);

$phonebook = new \Holger\Phonebook($res);

$numbers = [
    new \Holger\Entities\PhoneNumber("01234567890", 0, \Holger\Entities\PhoneNumber::TYPE_MOBILE, 1),
    \Holger\Entities\PhoneNumber::newHome("01012345", 1, 0)
];

$entry = \Holger\Entities\PhonebookEntry::create("Name", $numbers, "test@mail.com");
$phonebook->addPhonebookEntry(0, $entry);