<?php


namespace Holger;


trait HasEndpoint
{
    protected $conn = null;

    public function __construct(TR064Connection $fritz)
    {
        $this->conn = $fritz;
    }

    /**
     * @return \SoapClient
     */
    protected function prepareRequest()
    {
        return $this->conn->makeRequest($this->endpoint);
    }

    /**
     * @return \SimpleXMLElement
     */
    public function inspectEndpoint()
    {
        $url = $this->conn->makeUri($this->endpoint['scpdurl']);

        return simplexml_load_file($url);
    }
}