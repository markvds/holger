<?php

namespace Holger\Modules;

use Holger\HasEndpoint;

class DeviceInfo
{
    protected $endpoint = [
        'controlUri' => '/upnp/control/deviceinfo',
        'uri' => 'urn:dslforum-org:service:DeviceInfo:1',
        'scpdurl' => '/deviceinfoSCPD.xml',
    ];

    use HasEndpoint;

    /**
     * Fetch info like manufacturer, model name, serial number,
     * firmware version....
     *
     * @return array
     */
    public function info()
    {
        return $this->prepareRequest()->GetInfo();
    }

    /**
     * Fetch the latest device log entries.
     *
     * @return string
     */
    public function deviceLog()
    {
        return $this->prepareRequest()->GetDeviceLog();
    }

    /**
     * Fetch the port number to use for a secure connection.
     *
     * @return int
     */
    public function securityPort()
    {
        return intval($this->prepareRequest()->GetSecurityPort());
    }
}
