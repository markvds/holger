<?php


namespace Holger;

class DECTInfo
{

    protected $endpoint = [
        'controlUri' => "/upnp/control/x_contact",
        'uri' => "urn:dslforum-org:service:X_AVM-DE_OnTel:1",
        'scpdurl' => "/x_contactSCPD.xml",
    ];

    use HasEndpoint;

    public function getHandsets()
    {
        return explode(",", $this->prepareRequest()->GetDECTHandsetList());
    }

    public function getFullHandsetInfo()
    {
        $handsets = $this->getHandsets();
        $result = [];

        foreach ($handsets as $handset) {
            $result[$handset] = $this->getHandsetInfo($handset);
        }

        return $result;
    }

    public function getHandsetInfo($handsetId)
    {
        $idParam = new \SoapParam($handsetId, "NewDectID");

        return $this->prepareRequest()->GetDECTHandsetInfo($idParam);
    }
}