<?php


namespace Holger\Entities;


class PhoneNumber
{
    public $type;
    public $prio;
    public $id;

    public $number;

    public function __construct(string $number, int $id, string $type, int $prio)
    {
        $this->id = $id;
        $this->type = $type;
        $this->prio = $prio;
        $this->number = $number;
    }
}