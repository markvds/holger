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

echo "\n\n Holger Function Overview\n===========================\n\n";

echo "1. Call List:\n";
$callList = new \Holger\CallList($res);

echo "Call List URL: " . $callList->getCallListUrl() . "\n";
echo "Last 10 calls:\n\n";
echo $callList->getCallList(['max' => 10, 'type' => 'csv']);

echo "\n2. DECT Info:\n";

$dectInfo = new \Holger\DECTInfo($res);
$handsets = $dectInfo->getHandsets();
echo "List of handsets: " . implode(", ", $handsets) . "\n";
if (count($handsets) > 0) {
    $info = $dectInfo->getHandsetInfo($handsets[0]);
    echo "Name of first handset: " . $info['NewHandsetName'] . "\n";
}

echo "\n3. IP Addresses:\n";
$wanip = new \Holger\WANIP($res);

echo "External IP: " . $wanip->externalIP() . "\n";
echo "Uptime: " . $wanip->status()->getUptime() . "s\n";

try {
    echo "External IPv6: " . $wanip->externalIPv6() . "\n";
} catch (\Holger\Exceptions\IPv6UnavailableException $e) {
    echo "IPv6 unavailable!\n";
}

echo "\n4. Package Counter:\n";
$packageCounter = new \Holger\PackageCounter($res);
$stats = $packageCounter->statistics();
echo "Sent Bytes: " . $stats['bytesSent']->megaBytes() . " MB\n";
echo "Received Bytes: " . $stats['bytesReceived']->megaBytes() . " MB\n";

echo "\n5. Device Info:\n";
$deviceInfo = new \Holger\DeviceInfo($res);
echo "Port for secure connection: " . $deviceInfo->securityPort() . "\n";

$wanstats = new \Holger\WANStats($res);

$linkProperties = $wanstats->linkProperties();
echo "Downstream Byte Rate: " . $linkProperties->getDownstreamBitRate()->megaBytes() . " MB/s\n";
echo "Upstream Byte Rate: " . $linkProperties->getUpstreamBitRate()->megaBytes() . " MB/s\n";

/*$phonebook = new \Holger\Phonebook($res);

try {
    dump($phonebook->entry(1, 0, true));
} catch (SoapFault $e) {
    dump($e);
}*/