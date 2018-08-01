<?php

use PHPUnit\Framework\TestCase;

class WANStatsTest extends TestCase
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
    public function it_can_fetch_link_properties()
    {
        $link = $this->holger->stats->linkProperties();

        $this->assertInstanceOf(\Holger\Entities\Link::class, $link);
    }

    /** @test */
    public function it_can_fetch_transferred_bytes()
    {
        $stats = $this->holger->stats->byteStats();

        $this->assertArrayHasKey('sent', $stats);
        $this->assertInstanceOf(\Holger\Values\Byte::class, $stats['sent']);
        $this->assertArrayHasKey('received', $stats);
        $this->assertInstanceOf(\Holger\Values\Byte::class, $stats['received']);
    }

    /** @test */
    public function it_can_fetch_transferred_packets()
    {
        $stats = $this->holger->stats->packetStats();

        $this->assertArrayHasKey('sent', $stats);
        $this->assertTrue(is_numeric($stats['sent']));
        $this->assertArrayHasKey('received', $stats);
        $this->assertTrue(is_numeric($stats['received']));
    }
}
