<?php

namespace Holger\Modules;

use Holger\Entities\TamMessage;
use Holger\HasEndpoint;
use Holger\Entities\AnsweringMachine as AnsweringMachineInfo;

class AnsweringMachine
{

    protected $endpoint = [
        'controlUri' => '/upnp/control/x_tam',
        'uri' => 'urn:dslforum-org:service:X_AVM-DE_TAM:1',
        'scpdurl' => '/x_tamSCPD.xml',
    ];

    use HasEndpoint;

    public function getInfo($index = 0)
    {
        $idParam = new \SoapParam($index, 'NewIndex');

        $answer = $this->prepareRequest()->GetInfo($idParam);

        return new AnsweringMachineInfo(
            $index,
            $answer['NewName'],
            $answer['NewEnable'],
            $answer['NewTAMRunning'],
            $answer['NewStick'],
            $answer['NewCapacity'],
            $answer['NewStick']
        );
    }

    public function getMessageListUrl($index = 0)
    {
        $idParam = new \SoapParam($index, 'NewIndex');

        return $this->prepareRequest()->GetMessageList($idParam);
    }

    /**
     * Fetch a list of messages that are stored on the answering machine
     * Identify your answering machine by the index. To download the messages
     * you have to supply a SID. This can be fetched by the getSid method
     * in the DeviceInfo class. Pass the result of this method as a second
     * argument to let this class generate the correct urls for you.
     *
     * @param int         $index
     * @param string|null $sid
     * @param int|null    $max
     *
     * @return TamMessage[]
     */
    public function getMessageList($index = 0, $sid = null, $max = null)
    {
        $url = $this->getMessageListUrl($index);

        if ($max !== null) {
            $url .= '&max=' . $max;
        }

        $data = simplexml_load_file($url);

        $messages = [];

        $sid = $this->getSid();

        foreach ($data as $message) {
            $url = $this->appendSid($this->conn->makeUri((string)$message->Path), $sid);
            $messages[] = new TamMessage(
                (int)$message->Index,
                (int)$message->Tam,
                (string)$message->Number,
                (string)$message->Called,
                (string)$message->Date,
                (string)$message->Duration,
                (int)$message->Inbook,
                (string)$message->Name,
                (int)$message->New,
                $url
            );
        }

        return $messages;
    }
}
