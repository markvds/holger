<?php


namespace Holger;


class WANIP
{
    protected $endpoint = [
        'controlUri' => '/igdupnp/control/WANIPConn1',
        'uri' => 'urn:schemas-upnp-org:service:WANIPConnection:1',
        'scpdurl' => '/wanipconnSCPD.xml',
    ];

    use HasEndpoint;


    public function status()
    {
        return $this->prepareRequest()->GetStatusInfo();
    }

    public function externalIP()
    {
        return $this->prepareRequest()->GetExternalIPAddress();
    }
}