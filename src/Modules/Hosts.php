<?php

namespace Holger\Modules;

use Holger\HasEndpoint;

class Hosts
{
    protected $endpoint = [
        'controlUri' => '/upnp/control/hosts',
        'uri' => 'urn:dslforum-org:service:Hosts:1',
        'scpdurl' => '/hostsSCPD.xml',
    ];

    use HasEndpoint;

    public function meshListUrl()
    {
        $url = $this->prepareRequest()->__call(
            'X_AVM-DE_GetMeshListPath', []
        );

        return $this->conn->makeUri($url);
    }

    public function getMeshList($decode = true)
    {
        $data = file_get_contents($this->meshListUrl());

        return ($decode) ? json_decode($data, true) : $data;
    }
}
