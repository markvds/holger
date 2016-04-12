<?php

namespace Holger\Values;

class Byte implements \JsonSerializable
{

    protected $bits;

    public function __construct($bits)
    {
        $this->bits = $bits;
    }

    /**
     * @param $bytes
     *
     * @return Byte
     */
    public static function fromBytes($bytes)
    {
        return new static($bytes * 8);
    }

    public function bytes()
    {
        return $this->bits() / 8;
    }

    public function bits()
    {
        return $this->bits;
    }

    public function kiloBytes()
    {
        return $this->bytes() / 1000;
    }

    public function kibiBytes()
    {
        return $this->bytes() / 1024;
    }

    public function megaBytes()
    {
        return $this->kiloBytes() / 1000;
    }

    public function mebiBytes()
    {
        return $this->kibiBytes() / 1024;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *               which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return $this->bytes();
    }
}
