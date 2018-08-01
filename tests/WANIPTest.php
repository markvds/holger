<?php

use PHPUnit\Framework\TestCase;

class WANIPTest extends TestCase
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
    public function it_can_fetch_ipv4()
    {
        $ip = $this->holger->ip->externalIP();

        $this->assertNotFalse(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4));
    }

    /** @test */
    public function it_can_fetch_wan_status()
    {
        $status = $this->holger->ip->status();

        $this->assertInstanceOf(\Holger\Entities\WANStatus::class, $status);
    }
}
