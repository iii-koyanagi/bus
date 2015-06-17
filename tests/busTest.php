<?php

namespace TripleI\bus;

class busTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bus
     */
    protected $skeleton;

    protected function setUp()
    {
        parent::setUp();
        $this->skeleton = new bus;
    }

    public function testNew()
    {
        $actual = $this->skeleton;
        $this->assertInstanceOf('\TripleI\bus\bus', $actual);
    }

    public function testException()
    {
        $this->setExpectedException('\TripleI\bus\Exception\LogicException');
        throw new Exception\LogicException;
    }

    public function testBus()
    {
        $priceAndPassengers = '220:Cp,In';
        $bus = new bus();
        $bus->bus($priceAndPassengers);
    }
}
