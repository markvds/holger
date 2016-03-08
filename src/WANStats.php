<?php


namespace Holger;


class WANStats
{
    protected $endpoint = [
        'controlUri' => '/igdupnp/control/WANCommonIFC1',
        'uri' => 'urn:schemas-upnp-org:service:WANCommonInterfaceConfig:1',
        'scpdurl' => '/igdicfgSCPD.xml'
    ];

    use HasEndpoint;

    /**
     * Get info about the established WAN connection
     * returns upstream and downstream bitrate, link status and access type
     * @return array
     */
    public function linkProperties()
    {
        return $this->prepareRequest()->GetCommonLinkProperties();
    }

    /**
     * Returns sent and received bytes since restart
     * @return array
     */
    public function byteStats()
    {
        $client = $this->prepareRequest();
        return ['sent' => $client->GetTotalBytesSent(), 'received' => $client->GetTotalBytesReceived()];
    }

    /**
     * Returns sent and received packages since restart
     * @return array
     */
    public function packetStats()
    {
        $client = $this->prepareRequest();
        return ['sent' => $client->GetTotalPacketsSent(), 'received' => $client->GetTotalPacketsReceived()];
    }
}