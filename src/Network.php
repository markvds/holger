<?php


namespace Holger;


class Network
{
    protected $endpoint = [
        'controlUri' => "/upnp/control/hosts",
        'uri' => "urn:dslforum-org:service:Hosts:1",
        'scpdurl' => "/hostsSCPD.xml",
    ];

    use HasEndpoint;

    public function numberOfHostEntries()
    {
        return (int)$this->prepareRequest()->GetHostNumberOfEntries();
    }

    public function hostById($id)
    {
        $idParam = new \SoapParam($id, "NewIndex");
        return $this->prepareRequest()->GetGenericHostEntry($idParam);
    }

    public function hostByMAC($mac)
    {
        $macParam = new \SoapParam($mac, "NewMACAddress");

        return $this->prepareRequest()->GetSpecificHostEntry($macParam);
    }
}