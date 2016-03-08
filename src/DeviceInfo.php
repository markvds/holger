<?php


namespace Holger;


class DeviceInfo
{
    protected $endpoint = [
        'controlUri' => "/upnp/control/deviceinfo",
        'uri' => "urn:dslforum-org:service:DeviceInfo:1",
        'scpdurl' => "/deviceinfoSCPD.xml",
    ];

    use HasEndpoint;

    public function info()
    {
        return $this->prepareRequest()->GetInfo();
    }

    public function deviceLog()
    {
        return $this->prepareRequest()->GetDeviceLog();
    }

    public function securityPort()
    {
        return $this->prepareRequest()->GetSecurityPort();
    }
}