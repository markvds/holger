<?php


namespace Holger;

use Holger\Exceptions\SubstationNotFound;

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

    /**
     * Resolves a substation id, that is provided by the call monitor
     * to indicate the used handset for the call.
     * @param $substationId
     * @return array
     * @throws SubstationNotFound
     */
    public function resolveSubstation($substationId)
    {
        $phonebook = new Phonebook($this->conn);

        $entries = $phonebook->entries(0);

        $result = $entries->xpath("//contact[uniqueid=\"" . intval($substationId) . "\"]");

        if (count($result) == 0) {
            throw new SubstationNotFound();
        } else {
            $item = $result[0];
            return [
                'uniqueId' => intval($item->uniqueid),
                'realName' => strval($item->person->realName),
                'number' => strval($item->telephony->number),
            ];
        }
    }
}