<?php

namespace Holger\Entities;

use Carbon\Carbon;

class TamMessage
{

    public $index;
    public $tam;
    public $caller;
    public $called;
    public $date;
    public $duration;
    public $inPhoneBook;
    public $name;
    public $new;

    protected $path;

    /**
     * TamMessage constructor.
     *
     * @param $index
     * @param $tam
     * @param $caller
     * @param $called
     * @param $date
     * @param $duration
     * @param $inPhoneBook
     * @param $name
     * @param $new
     * @param $path
     */
    public function __construct(
        $index,
        $tam,
        $caller,
        $called,
        $date,
        $duration,
        $inPhoneBook,
        $name,
        $new,
        $path
    ) {
        $this->index = $index;
        $this->tam = $tam;
        $this->caller = $caller;
        $this->called = $called;

        if (!($date instanceof \DateTime)) {
            $this->date = Carbon::createFromFormat('d.m.y H:i', $date);
        } else {
            $this->date = $date;
        }

        $this->duration = $duration;
        $this->inPhoneBook = $inPhoneBook;
        $this->name = $name;
        $this->new = $new;
        $this->path = $path;
    }
}
