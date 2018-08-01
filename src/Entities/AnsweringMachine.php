<?php

namespace Holger\Entities;

use Holger\Values\Byte;


class AnsweringMachine
{
    /**
     * Create new answering machine info
     *
     * @param integer $index
     * @param string $name
     * @param boolean $enabled
     * @param boolean $running
     * @param integer $status Bit 0: busy, Bit 1: no space left, Bit 15: Display in WebUI
     * @param integer $capacity Remaining minutes, that can be recorded
     * @param integer $stick 0 = no stick, 1 = stick and running, 2 = stick, but missing avm_tam folder
     */
    public function __construct($index, $name, $enabled, $running, $status, $capacity, $stick)
    {
        $this->index = (int) $index;
        $this->name = $name;
        $this->enabled = (boolean) $enabled;
        $this->running = (boolean) $running;
        $this->status = (int) $status;
        $this->capacity = (int) $capacity;
        $this->stick = (int) $stick;
    }

    /**
     * Returns true only if the TAM is correctly configured
     *
     * @return boolean
     */
    public function isStickConfigured()
    {
        return $this->stick === 1;
    }

    /**
     * Returns true, if there is a stick, but it is not configured
     * to receive TAM messages, i.e. the avm_tam directory is missing
     *
     * @return boolean
     */
    public function missingStickConfig()
    {
        return $this->stick === 2;
    }
}
