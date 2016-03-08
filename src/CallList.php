<?php


namespace Holger;

class CallList
{

    protected $endpoint = [
        'controlUri' => '/upnp/control/x_contact',
        'uri' => 'urn:dslforum-org:service:X_AVM-DE_OnTel:1',
        'scpdurl' => '/x_contactSCPD.xml',
    ];

    use HasEndpoint;

    public function getCallListUrl()
    {
        return $this->prepareRequest()->GetCallList();
    }

    public function getCallList()
    {
        $url = $this->getCallListUrl();

        return simplexml_load_file($url);
    }
}