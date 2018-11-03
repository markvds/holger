<?php

use PHPUnit\Framework\TestCase;

class WANMonitorTest extends TestCase
{
    /**
     * @var \Holger\Holger
     */
    protected $holger;

    protected function setUp()
    {
        $this->holger = new \Holger\Holger($_ENV['ROUTER_HOST'], $_ENV['ROUTER_PASSWORD'], $_ENV['ROUTER_USERNAME']);
    }

    /** @test */
    public function it_can_fetch_a_dataset()
    {
        $onlinemonitor = $this->holger->monitor->getOnlineMonitor();
        $this->assertArrayHasKey('Newds_current_bps', $onlinemonitor);
        $this->assertArrayHasKey('Newus_current_bps', $onlinemonitor);
    }
}
