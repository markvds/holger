<?php

use PHPUnit\Framework\TestCase;

class CallListTest extends TestCase
{

    /**
     * @var \Holger\Modules\CallList
     */
    protected $callList;

    /**
     *
     * @var \Holger\Holger
     */
    protected $holger;

    protected function setUp()
    {
        $this->holger = new \Holger\Holger($_ENV['ROUTER_HOST'], $_ENV['ROUTER_PASSWORD'], $_ENV['ROUTER_USERNAME']);
        $this->callList = $this->holger->calls;
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

        //var_dump($callList[0][0]);

        $this->assertInstanceOf(SimpleXMLElement::class, $callList);
    }
}
