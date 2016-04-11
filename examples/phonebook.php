<?php

require_once "../vendor/autoload.php";

$credentials = [
    'username' => 'user',
    'password' => 'password'
];

if (file_exists('../config.php')) {
    $loadedCredentials = include '../config.php';

    $credentials = array_merge($credentials, $loadedCredentials);
}

$res = new Holger\TR064Connection('192.168.178.1', $credentials['password'], $credentials['username']);

$phonebook = new \Holger\Phonebook($res);

$entry = \Holger\Entities\PhonebookEntry::create("Name", [new \Holger\Entities\PhoneNumber("01234567890", 0, "mobile", 1)], "test@mail.com");
$phonebook->addPhonebookEntry(0, $entry);