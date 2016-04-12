<?php

namespace Holger\Entities;

class PhonebookEntry
{

    public $realName;
    public $category;
    public $numbers;
    public $email;
    public $modTime;
    public $uniqueid;

    /**
     * PhonebookEntry constructor.
     * @param $realName
     * @param $category
     * @param PhoneNumber[] $numbers
     * @param $email
     * @param $modTime
     * @param $uniqueid
     */
    public function __construct($realName, $category, array $numbers, $email, $modTime, $uniqueid)
    {
        $this->realName = $realName;
        $this->category = $category;
        $this->numbers = $numbers;
        $this->email = $email;
        $this->modTime = $modTime;
        $this->uniqueid = $uniqueid;
    }

    /**
     * Simplified constructor to create a new phonebook entry.
     *
     * @param $realName
     * @param PhoneNumber[] $numbers
     * @param $email
     * @return PhonebookEntry
     */
    public static function create($realName, array $numbers, $email)
    {
        return new static($realName, 0, $numbers, $email, time(), null);
    }
}
