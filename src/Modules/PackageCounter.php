<?php

namespace Holger\Modules;

use Holger\HasEndpoint;
use Holger\Values\Byte;

class PackageCounter
{
    protected $endpoint = [
        'controlUri' => '/upnp/control/lanethernetifcfg',
        'uri' => 'urn:dslforum-org:service:LANEthernetInterfaceConfig:1',
        'scpdurl' => '/ethifconfigSCPD.xml',
    ];

    use HasEndpoint;

    public function info()
    {
        return $this->prepareRequest()->GetInfo();
    }

    public function statistics()
    {
        $response = $this->prepareRequest()->GetStatistics();

        return [
            'bytesSent' => Byte::fromBytes($response['NewBytesSent']),
            'bytesReceived' => Byte::fromBytes($response['NewBytesReceived']),
            'packetsSent' => $response['NewPacketsSent'],
            'packetsReceived' => $response['NewPacketsReceived'],
        ];
    }
}
