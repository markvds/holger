<?php


class WANIPTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Holger\WANIP
     */
    protected $wanIp;

    protected function setUp()
    {
        $conn = new \Holger\TR064Connection($_ENV['ROUTER_HOST'], $_ENV['ROUTER_PASSWORD'], $_ENV['ROUTER_USERNAME']);
        $this->wanIp = new \Holger\WANIP($conn);
    }

    /** @test */
    public function it_can_fetch_ipv4()
    {
        $ip = $this->wanIp->externalIP();


        $this->assertNotFalse(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4));
    }

    /** @test */
    public function it_can_fetch_wan_status()
    {
        $status = $this->wanIp->status();

        $this->assertTrue(is_array($status));
        $this->assertArrayHasKey('NewConnectionStatus', $status);
        $this->assertArrayHasKey('NewLastConnectionError', $status);
        $this->assertArrayHasKey('NewUptime', $status);
    }
}
