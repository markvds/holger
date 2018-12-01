<?php

namespace Holger;

trait HasEndpoint
{
    protected $conn = null;

    public function __construct(TR064Connection $conn)
    {
        $this->conn = $conn;
    }

    /**
     * @param null $endpoint
     *
     * @return \SoapClient
     */
    protected function prepareRequest($endpoint = null)
    {
        return $this->conn->makeRequest($endpoint ?? $this->endpoint);
    }

    /**
     * @return \SimpleXMLElement
     */
    public function inspectEndpoint()
    {
        $url = $this->conn->makeUri($this->endpoint['scpdurl']);

        return simplexml_load_file($url);
    }

    public function appendSid($url, $sid = null)
    {
        if (strpos($url, 'sid=') === false) {
            $sid = $sid ?? $this->getSid();
            return $url . (parse_url($url, PHP_URL_QUERY) ? '&' : '?') . $sid;
        }

        return $url;
    }

    public function getSid()
    {
        $endpoint = [
            'controlUri' => '/upnp/control/deviceconfig',
            'uri' => 'urn:dslforum-org:service:DeviceConfig:1',
            'scpdurl' => '/deviceconfigSCPD.xml',
        ];
        return $this->prepareRequest($endpoint)->__soapCall('X_AVM-DE_CreateUrlSID', []);
    }
}
