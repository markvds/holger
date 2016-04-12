<?php

class WANStatsTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var \Holger\WANStats
     */
    protected $wanStats;

    protected function setUp()
    {
        $conn = new \Holger\TR064Connection($_ENV['ROUTER_HOST'], $_ENV['ROUTER_PASSWORD'], $_ENV['ROUTER_USERNAME']);
        $this->wanStats = new \Holger\WANStats($conn);
    }

    /** @test */
    public function it_can_fetch_link_properties()
    {
        $link = $this->wanStats->linkProperties();

        $this->assertInstanceOf(\Holger\Entities\Link::class, $link);

    }

    /** @test */
    public function it_can_fetch_transferred_bytes()
    {
        $stats = $this->wanStats->byteStats();

        $this->assertArrayHasKey('sent', $stats);
        $this->assertInstanceOf(\Holger\Values\Byte::class, $stats['sent']);
        $this->assertArrayHasKey('received', $stats);
        $this->assertInstanceOf(\Holger\Values\Byte::class, $stats['received']);

    }

    /** @test */
    public function it_can_fetch_transferred_packets()
    {
        $stats = $this->wanStats->packetStats();

        $this->assertArrayHasKey('sent', $stats);
        $this->assertTrue(is_numeric($stats['sent']));
        $this->assertArrayHasKey('received', $stats);
        $this->assertTrue(is_numeric($stats['received']));
    }
}
