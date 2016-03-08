<?php

namespace Holger;

/**
 *
 */
class Phonebook
{

    protected $endpoint = [
        'controlUri' => '/upnp/control/x_contact',
        'uri' => 'urn:dslforum-org:service:X_AVM-DE_OnTel:1',
        'scpdurl' => '/x_contactSCPD.xml',
    ];

    use HasEndpoint;

    /**
     * List all available phonebooks
     * @return array
     */
    public function getPhonebooks()
    {
        $response = $this->prepareRequest()->GetPhonebookList();

        return explode(',', $response);
    }

    /**
     * Fetch the url to get the entries of a phonebook
     * @param $phonebookId
     * @return string
     */
    public function entriesUrl($phonebookId)
    {
        $idParam = new \SoapParam((int)$phonebookId, 'NewPhonebookID');

        return $this->prepareRequest()->GetPhonebook($idParam);
    }

    /**
     * List all phonebook entries of a given phonebook
     * @param $phonebookId
     * @return \SimpleXMLElement
     */
    public function entries($phonebookId)
    {
        $url = $this->entriesUrl($phonebookId);

        return simplexml_load_file($url['NewPhonebookURL']);
    }

    public function getInfoByIndex($index)
    {
        $idParam = new \SoapParam((int)$index, 'NewIndex');

        return $this->prepareRequest()->GetInfoByIndex($idParam);
    }

    /**
     * Fetch entry $entryId of phonebook $phonebookId
     * @param $entryId
     * @param $phonebookId
     * @param bool $raw
     * @return \SimpleXMLElement|string
     */
    public function entry($entryId, $phonebookId, $raw = false)
    {
        $idParam = new \SoapParam((int)$phonebookId, 'NewPhonebookID');
        $entryParam = new \SoapParam((int)$entryId, 'NewPhonebookEntryID');
        $response = $this->prepareRequest()->GetPhonebookEntry($idParam, $entryParam);
        if ($raw) {
            return $response;
        }
        return simplexml_load_string($response);
    }
}