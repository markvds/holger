<?php

namespace Holger\Entities;

class WANStatus implements \JsonSerializable
{

    /**
     * @var string
     */
    private $connectionStatus;
    /**
     * @var string
     */
    private $lastConnectionError;
    /**
     * @var int
     */
    private $uptime;

    public function __construct($connectionStatus, $lastConnectionError, $uptime)
    {

        $this->connectionStatus = $connectionStatus;
        $this->lastConnectionError = $lastConnectionError;
        $this->uptime = intval($uptime);
    }

    public static function fromResponse($response)
    {
        return new static($response['NewConnectionStatus'], $response['NewLastConnectionError'],
            $response['NewUptime']);
    }

    /**
     * @return string
     */
    public function getConnectionStatus()
    {
        return $this->connectionStatus;
    }

    /**
     * @return string
     */
    public function getLastConnectionError()
    {
        return $this->lastConnectionError;
    }

    /**
     * @return int
     */
    public function getUptime()
    {
        return $this->uptime;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *               which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
