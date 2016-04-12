<?php

class CallListTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var \Holger\CallList
     */
    protected $callList;

    protected function setUp()
    {
        $conn = new \Holger\TR064Connection($_ENV['ROUTER_HOST'], $_ENV['ROUTER_PASSWORD'], $_ENV['ROUTER_USERNAME']);
        $this->callList = new \Holger\CallList($conn);
    }

    /** @test */
    public function it_can_fetch_callList_url()
    {
        $url = $this->callList->getCallListUrl();

        $this->assertNotFalse(filter_var($url, FILTER_VALIDATE_URL,
            FILTER_FLAG_PATH_REQUIRED | FILTER_FLAG_QUERY_REQUIRED));
    }

    /** @test */
    public function it_can_fetch_callList()
    {
        $callList = $this->callList->getCallList();

        $this->assertInstanceOf(SimpleXMLElement::class, $callList);
    }
}
