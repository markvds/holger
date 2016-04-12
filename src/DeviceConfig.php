<?php

namespace Holger;


class DeviceConfig
{
    protected $endpoint = [
        'controlUri' => '/upnp/control/deviceconfig',
        'uri' => 'urn:dslforum-org:service:DeviceConfig:1',
        'scpdurl' => '/deviceconfigSCPD.xml',
    ];

    use HasEndpoint;

    public function getSid()
    {
        return $this->prepareRequest()->__soapCall("X_AVM-DE_CreateUrlSID", []);
    }
}