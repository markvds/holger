<?php

namespace Holger\Modules;

use Holger\HasEndpoint;

class Voip
{

    protected $endpoint = [
        'controlUri' => '/upnp/control/x_voip',
        'uri' => 'urn:dslforum-org:service:X_VoIP:1',
        'scpdurl' => '/x_voipSCPD.xml',
    ];

    use HasEndpoint;

    public function quickInfo()
    {
        return $this->prepareRequest()->GetInfo();
    }

    public function info()
    {
        return $this->prepareRequest()->GetInfoEx();
    }

    /**
     * Get the number of available VOIP numbers.
     *
     * @return mixed
     */
    public function countExistingNumbers()
    {
        return $this->prepareRequest()->GetExistingVoIPNumbers();
    }

    /**
     * Get the phone name, that is used by the call assistance
     *
     * @return mixed
     */
    public function callingPhone()
    {
        return $this->prepareRequest()->__call('X_AVM-DE_DialGetConfig', []);
    }

    /**
     * Call the given number. Make sure, to enable the call assistance
     * feature ("Wählhilfe") in your router. For basic signaling via ringing,
     * you can select the cable phone port as the source in your router config.
     *
     * @param $number
     *
     * @return mixed
     */
    public function call($number)
    {
        $phoneNumber = new \SoapParam($number, 'NewX_AVM-DE_PhoneNumber');

        return $this->prepareRequest()->__call(
            'X_AVM-DE_DialNumber', [$phoneNumber]
        );
    }

    /**
     * Stop the current calling process
     *
     * @return mixed
     */
    public function hangup()
    {
        return $this->prepareRequest()->__call(
            'X_AVM-DE_DialHangup', []
        );
    }
}
