<?php


class NetworkTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Holger\Network
     */
    protected $network;

    protected function setUp()
    {
        $conn = new \Holger\TR064Connection($_ENV['ROUTER_HOST'], $_ENV['ROUTER_PASSWORD'], $_ENV['ROUTER_USERNAME']);
        $this->network = new \Holger\Network($conn);
    }

    /** @test */
    public function it_can_fetch_number_of_known_hosts()
    {
        $number = $this->network->numberOfHostEntries();

        $this->assertTrue(is_numeric($number));
    }

    /** @test */
    public function it_can_fetch_hosts_by_id()
    {
        $id = $this->network->numberOfHostEntries() - 1;
        $host = $this->network->hostById($id);

        //$this->assertTrue(is_array($host));
        $this->assertInstanceOf(\Holger\Entities\Host::class, $host);

    }

    /** @test */
    public function it_can_fetch_host_by_mac()
    {
        $oneHost = $this->network->hostById(0);
        $mac = $oneHost->getMacAddress();

        $host = $this->network->hostByMAC($mac);

        $this->assertInstanceOf(\Holger\Entities\Host::class, $host);
        $this->assertEquals($oneHost->getIpAddress(), $host->getIpAddress());
    }

}
