<?php

namespace Holger;

/**
 *
 */
class Phonebook
{

    protected $endpoint = [
        'controlUri' => "/upnp/control/x_contact",
        'uri' => "urn:dslforum-org:service:X_AVM-DE_OnTel:1",
        'scpdurl' => "/x_contactSCPD.xml",
    ];

    use HasEndpoint;

    public function getPhonebooks()
    {
        $response = $this->prepareRequest()->GetPhonebookList();

        return explode(',', $response);
    }

    public function entries($phonebookId)
    {
        $idParam = new \SoapParam((int)$phonebookId, "NewPhonebookID");

        return $this->prepareRequest()->GetPhonebook($idParam);
    }

    public function getInfoByIndex($index)
    {
        $idParam = new \SoapParam((int)$index, "NewIndex");

        return $this->prepareRequest()->GetInfoByIndex($idParam);
    }
}