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

    /**
     * List all available Handset IDs
     * URI: urn:dslforum-org:service:X_AVM-DE_OnTel:1#GetDECTHandsetList
     * @return array
     */
    public function getHandsets()
    {
        return explode(",", $this->prepareRequest()->GetDECTHandsetList());
    }

    /**
     * Retrieve full information about the handsets
     * i.e. call getHandsetInfo for each handset
     * @return array
     */
    public function getFullHandsetInfo()
    {
        $handsets = $this->getHandsets();
        $result = [];

        foreach ($handsets as $handset) {
            $result[$handset] = $this->getHandsetInfo($handset);
        }

        return $result;
    }

    /**
     * Returns all available information about one handset.
     * Fields: NewHandsetName, NewPhonebookID
     * @param $handsetId
     * @return mixed
     */
    public function getHandsetInfo($handsetId)
    {
        $idParam = new \SoapParam($handsetId, "NewDectID");

        return $this->prepareRequest()->GetDECTHandsetInfo($idParam);
    }
}