<?php

namespace Holger\Modules;

use Holger\HasEndpoint;
use Holger\Entities\OnlineMonitor;

class WANMonitor
{

    protected $endpoint = [
        'controlUri' => '/upnp/control/wancommonifconfig1',
        'uri' => 'urn:dslforum-org:service:WANCommonInterfaceConfig:1',
        'scpdurl' => '/wancommonifconfigSCPD.xml',
    ];

    use HasEndpoint;

    /**
     * Get statistics of wan utilization, like upstream and downstream.
     * This call is used by the fritz box network monitor view.
     *
     * @param int $newSyncGroupIndex
     *
     * @return OnlineMonitor
     */
    public function getOnlineMonitor($newSyncGroupIndex = 0)
    {
        $response = $this->prepareRequest()->__call(
            'X_AVM-DE_GetOnlineMonitor',
            [
                new \SoapParam((int)$newSyncGroupIndex, 'NewSyncGroupIndex'),
            ]
        );

        return new OnlineMonitor($response);
    }
}
