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

echo "\n\n Holger Function Overview\n===========================\n\n";

echo "1. Call List:\n";
$callList = new \Holger\CallList($res);

echo "Call List URL: " . $callList->getCallListUrl() . "\n";
echo "Last 10 calls:\n\n";
echo $callList->getCallList(['max' => 10, 'type' => 'csv']);

echo "\n\n2. DECT Info:\n";

$dectInfo = new \Holger\DECTInfo($res);
echo "List of handsets: " . implode(", ", $dectInfo->getHandsets()) . "\n\n";

echo "3. IP Addresses:\n";
$wanip = new \Holger\WANIP($res);

echo "External IP: " . $wanip->externalIP() . "\n";
echo "Uptime: " . $wanip->status()->getUptime() . "s\n";

try {
    echo "External IPv6: " . $wanip->externalIPv6() . "\n";
} catch (\Holger\Exceptions\IPv6UnavailableException $e) {
    echo "IPv6 unavailable!\n";
}

// $dect = new \Holger\DECTInfo($res);

// var_dump($dect->getHandsetInfo(1));

/*$phonebook = new \Holger\Phonebook($res);

try {
    dump($phonebook->entry(1, 0, true));
} catch (SoapFault $e) {
    dump($e);
}*/

/*$wanstats = new \Holger\WANStats($res);

var_dump($wanstats->packetStats());
var_dump($wanstats->linkProperties());*/

/*$packageCounter = new \Holger\PackageCounter($res);

dump($packageCounter->info());
dump($packageCounter->statistics());*/

/*$deviceInfo = new \Holger\DeviceInfo($res);

var_dump($deviceInfo->info());
var_dump($deviceInfo->securityPort());*/