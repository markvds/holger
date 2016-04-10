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

    public function getCallList(array $options = [])
    {
        $availableKeys = ['days' => '', 'id' => '', 'max' => '', 'timestamp' => '', 'type' => ''];
        $options = array_intersect_key($options, $availableKeys);

        $url = $this->getCallListUrl();

        if (!empty($options)) {
            $url = $url . '&' . http_build_query($options);
        }

        if (isset($options['type']) && $options['type'] === 'csv') {
            return file_get_contents($url);
        }

        return simplexml_load_file($url);
    }
}