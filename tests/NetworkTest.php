<?php

use PHPUnit\Framework\TestCase;

class NetworkTest extends TestCase
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
    public function it_can_fetch_number_of_known_hosts()
    {
        $number = $this->holger->network->numberOfHostEntries();

        $this->assertTrue(is_numeric($number));
    }

    /** @test */
    public function it_can_fetch_hosts_by_id()
    {
        $id = $this->holger->network->numberOfHostEntries() - 1;
        $host = $this->holger->network->hostById($id);

        //$this->assertTrue(is_array($host));
        $this->assertInstanceOf(\Holger\Entities\Host::class, $host);
    }

    /** @test */
    public function it_can_fetch_host_by_mac()
    {
        $oneHost = $this->holger->network->hostById(0);
        $mac = $oneHost->getMacAddress();

        $host = $this->holger->network->hostByMAC($mac);

        $this->assertInstanceOf(\Holger\Entities\Host::class, $host);
        $this->assertEquals($oneHost->getIpAddress(), $host->getIpAddress());
    }
}
