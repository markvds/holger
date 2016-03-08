<?php


namespace Holger;


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
        return $this->prepareRequest()->GetStatistics();
    }
}