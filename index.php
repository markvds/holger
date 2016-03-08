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

// $dect = new \Holger\DECTInfo($res);

// var_dump($dect->getHandsetInfo(1));

/*$phonebook = new \Holger\Phonebook($res);

try {
    var_dump($phonebook->entries(0));
} catch (SoapFault $e) {
    var_dump($e);
}*/

/*$wanip = new \Holger\WANIP($res);

var_dump($wanip->externalIP());

var_dump($wanip->externalIPv6());
var_dump($wanip->getIPv6Prefix());
var_dump($wanip->status());*/

/*$wanstats = new \Holger\WANStats($res);

var_dump($wanstats->packetStats());
var_dump($wanstats->linkProperties());*/

$packageCounter = new \Holger\PackageCounter($res);

var_dump($packageCounter->info());
var_dump($packageCounter->statistics());

/*$deviceInfo = new \Holger\DeviceInfo($res);

var_dump($deviceInfo->info());
var_dump($deviceInfo->securityPort());*/