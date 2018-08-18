<?php

namespace Holger;

class Holger
{
    protected $connection;

    protected $availableModules = [
        'answeringMachine' => \Holger\Modules\AnsweringMachine::class,
        'network' => \Holger\Modules\Network::class,
        'ip' => \Holger\Modules\WANIP::class,
        'monitor' => \Holger\Modules\WANMonitor::class,
        'stats' => \Holger\Modules\WANStats::class,
        'calls' => \Holger\Modules\CallList::class,
        'dect' => \Holger\Modules\DECTInfo::class,
        'counter' => \Holger\Modules\PackageCounter::class,
        'device' => \Holger\Modules\DeviceInfo::class,
        'phonebook' => \Holger\Modules\Phonebook::class
    ];

    protected $modules = [];

    public function __construct($host, $password, $username = null)
    {
        $this->connection = new TR064Connection($host, $password, $username);
    }

    public function __get($name)
    {
        if (!array_key_exists($name, $this->modules)) {
            $module = $this->availableModules[$name];
            $this->modules[$name] = new $module($this->connection);
        }

        return $this->modules[$name];
    }
}
