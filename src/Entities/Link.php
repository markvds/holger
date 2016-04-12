<?php

namespace Holger\Entities;

use Holger\Values\Byte;

class Link implements \JsonSerializable
{

    /**
     * @var string
     */
    private $wanAccessType;

    /**
     * @var Byte
     */
    private $upstreamBitRate;
    /**
     * @var Byte
     */
    private $downstreamBitRate;
    /**
     * @var string
     */
    private $physicalLinkStatus;

    public function __construct($wanAccessType, $upstreamBitRate, $downstreamBitRate, $physicalLinkStatus)
    {

        $this->wanAccessType = $wanAccessType;
        $this->upstreamBitRate = new Byte($upstreamBitRate);
        $this->downstreamBitRate = new Byte($downstreamBitRate);
        $this->physicalLinkStatus = $physicalLinkStatus;
    }

    public static function fromResponse($response)
    {
        return new static($response['NewWANAccessType'], $response['NewLayer1UpstreamMaxBitRate'],
            $response['NewLayer1DownstreamMaxBitRate'], $response['NewPhysicalLinkStatus']);
    }

    /**
     * @return string
     */
    public function getWanAccessType()
    {
        return $this->wanAccessType;
    }

    /**
     * @return Byte
     */
    public function getUpstreamBitRate()
    {
        return $this->upstreamBitRate;
    }

    /**
     * @return Byte
     */
    public function getDownstreamBitRate()
    {
        return $this->downstreamBitRate;
    }

    /**
     * @return string
     */
    public function getPhysicalLinkStatus()
    {
        return $this->physicalLinkStatus;
    }

    /**
     * Specify data which should be serialized to JSON.
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *               which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'wanAccessType' => $this->getWanAccessType(),
            'upstreamBitRate' => $this->getUpstreamBitRate()->bits(),
            'downstreamBitRate' => $this->getDownstreamBitRate()->bits(),
            'physicalLinkStatus' => $this->getPhysicalLinkStatus(),
        ];
    }
}
