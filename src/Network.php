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

    /**
     * Fetches the number of known hosts
     * These are the members of the network that have been registered some time.
     * @return int
     */
    public function numberOfHostEntries()
    {
        return (int)$this->prepareRequest()->GetHostNumberOfEntries();
    }

    /**
     * Get information about one peer in the local network.
     * Data includes the IP address (NewIPAddress), MAC Address (NewMACAddress)
     * and much more.
     * @param $id
     * @return array
     */
    public function hostById($id)
    {
        $idParam = new \SoapParam($id, "NewIndex");
        return $this->prepareRequest()->GetGenericHostEntry($idParam);
    }

    /**
     * Get information like IP address of a host given by the mac address
     * @param $mac
     * @return mixed
     */
    public function hostByMAC($mac)
    {
        $macParam = new \SoapParam($mac, "NewMACAddress");

        return $this->prepareRequest()->GetSpecificHostEntry($macParam);
    }
}