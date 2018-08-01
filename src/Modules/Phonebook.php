<?php

namespace Holger\Modules;

use Carbon\Carbon;
use Holger\Entities\PhonebookEntry;
use Holger\Entities\PhoneNumber;
use Holger\Exceptions\SubstationNotFound;
use Holger\PhonebookEntrySerializer;
use Holger\HasEndpoint;

class Phonebook
{

    protected $endpoint = [
        'controlUri' => '/upnp/control/x_contact',
        'uri' => 'urn:dslforum-org:service:X_AVM-DE_OnTel:1',
        'scpdurl' => '/x_contactSCPD.xml',
    ];

    use HasEndpoint;

    /**
     * List all available phonebooks.
     *
     * @return array
     */
    public function getPhonebooks()
    {
        $response = $this->prepareRequest()->GetPhonebookList();

        return explode(',', $response);
    }

    /**
     * Fetch the url to get the entries of a phonebook.
     *
     * @param $phonebookId
     *
     * @return string
     */
    public function entriesUrl($phonebookId)
    {
        $idParam = new \SoapParam((int)$phonebookId, 'NewPhonebookID');

        return $this->prepareRequest()->GetPhonebook($idParam);
    }

    /**
     * List all phonebook entries of a given phonebook.
     *
     * @param $phonebookId
     *
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
     * Fetch entry $entryId of phonebook $phonebookId.
     *
     * @param      $entryId
     * @param      $phonebookId
     * @param bool $raw
     *
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

        $response = simplexml_load_string($response);

        $entry = $this->extractPhonebookEntry($response);

        return $entry;
    }

    /**
     * Resolves a substation id, that is provided by the call monitor
     * to indicate the used handset for the call.
     *
     * @param $substationId
     *
     * @throws SubstationNotFound
     *
     * @return array
     */
    public function resolveSubstation($substationId)
    {
        $entries = $this->entries(0);

        $result = $entries->xpath('//contact[uniqueid="' . intval($substationId) . '"]');

        if (count($result) == 0) {
            throw new SubstationNotFound();
        } else {
            $item = $result[0];

            return $this->extractPhonebookEntry($item);
        }
    }

    public function addPhonebookEntry($phonebookId, PhonebookEntry $entry)
    {
        $serializedEntry = PhonebookEntrySerializer::serialize($entry);

        $idParam = new \SoapParam((int)$phonebookId, 'NewPhonebookID');
        $entryParam = new \SoapParam('', 'NewPhonebookEntryID');
        $entryDataParam = new \SoapParam($serializedEntry, 'NewPhonebookEntryData');

        return $this->prepareRequest()->SetPhonebookEntry($idParam, $entryParam, $entryDataParam);
    }

    /**
     * @param $response
     *
     * @return PhonebookEntry
     */
    protected function extractPhonebookEntry($response)
    {
        $numbers = [];

        foreach ($response->telephony->number as $number) {
            $attributes = $number->attributes();
            $numbers[] = new PhoneNumber($number, (int)$attributes['id'], $attributes['type'],
                (int)$attributes['prio']);
        }

        $timestamp = Carbon::createFromTimestamp((int)$response->mod_time);

        $entry = new PhonebookEntry((string)$response->person->realName, (int)$response->category, $numbers,
            (string)$response->services->email, $timestamp, (int)$response->uniqueid);

        return $entry;
    }
}
