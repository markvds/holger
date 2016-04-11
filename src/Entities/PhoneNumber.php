<?php


namespace Holger\Entities;


class PhoneNumber
{
    public $type;
    public $prio;
    public $id;

    public $number;

    const TYPE_HOME = 'home';
    const TYPE_MOBILE = 'mobile';
    const TYPE_WORK = 'work';
    const TYPE_FAX = 'fax_work';

    public function __construct(string $number, int $id, string $type, int $prio)
    {
        $this->id = $id;
        $this->type = $type;
        $this->prio = $prio;
        $this->number = $number;
    }

    /**
     * @param string $number
     * @param int $id
     * @param $prio
     * @return PhoneNumber
     */
    public static function newMobile(string $number, int $id, $prio)
    {
        return new static($number, $id, static::TYPE_MOBILE, $prio);
    }

    public static function newHome(string $number, int $id, $prio)
    {
        return new static($number, $id, static::TYPE_HOME, $prio);
    }

    public static function newWork(string $number, int $id, $prio)
    {
        return new static($number, $id, static::TYPE_WORK, $prio);
    }

    public static function newFax(string $number, int $id, $prio)
    {
        return new static($number, $id, static::TYPE_FAX, $prio);
    }
}