<?php

use PHPUnit\Framework\TestCase;

class HostsTest extends TestCase
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
    public function it_can_fetch_mesh_list_url()
    {
        $url = $this->holger->hosts->meshListUrl();

        $this->assertNotFalse(filter_var($url, FILTER_VALIDATE_URL));
    }

    /** @test */
    public function it_loads_the_meshlist()
    {
        $data = $this->holger->hosts->getMeshList();
        
        $this->assertTrue(is_array($data));
        $this->assertArrayHasKey('nodes', $data);
    }
}
