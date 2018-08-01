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

$holger = new Holger\Holger('192.168.178.1', $credentials['password'], $credentials['username']);

echo "\n\n Holger Function Overview\n===========================\n\n";

echo "1. Call List:\n";

echo 'Call List URL: ' . $holger->calls->getCallListUrl() . "\n";
echo "Last 10 calls:\n\n";
echo $holger->calls->getCallList(['max' => 10, 'type' => 'csv']);

echo "\n2. DECT Info:\n";

$handsets = $holger->dect->getHandsets();
echo 'List of handsets: ' . implode(', ', $handsets) . "\n";
if (count($handsets) > 0) {
    $info = $holger->dect->getHandsetInfo($handsets[0]);
    echo 'Name of first handset: ' . $info['NewHandsetName'] . "\n";
}

echo "\n3. IP Addresses:\n";

echo 'External IP: ' . $holger->ip->externalIP() . "\n";
echo 'Uptime: ' . $holger->ip->status()->getUptime() . "s\n";

try {
    echo 'External IPv6: ' . $holger->ip->externalIPv6() . "\n";
} catch (\Holger\Exceptions\IPv6UnavailableException $e) {
    echo "IPv6 unavailable!\n";
}

echo "\n4. Package Counter:\n";
$stats = $holger->counter->statistics();
echo 'Sent Bytes: ' . $stats['bytesSent']->megaBytes() . " MB\n";
echo 'Received Bytes: ' . $stats['bytesReceived']->megaBytes() . " MB\n";

echo "\n5. Device Info:\n";

echo 'Port for secure connection: ' . $holger->device->securityPort() . "\n";

$linkProperties = $holger->stats->linkProperties();
echo 'Downstream Byte Rate: ' . $linkProperties->getDownstreamBitRate()->megaBytes() . " MB/s\n";
echo 'Upstream Byte Rate: ' . $linkProperties->getUpstreamBitRate()->megaBytes() . " MB/s\n";
