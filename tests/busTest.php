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
        $data = '1210:An,Ip,In,Iw,An,Iw,Iw,An,Iw,Iw';
        $bus = new bus();

        $edit_data = $bus->editData($data);
        $adultsAndChildCalculate = $bus->adultsAndChildCalculate($edit_data);

        $price = $edit_data[0];
        $passengersArray = $edit_data[1];
        $adult_number = $adultsAndChildCalculate[0];
        $adult_and_child_total = $adultsAndChildCalculate[1];

        $total = $bus->infantCalculateAndAllTotal($price, $passengersArray, $adult_number, $adult_and_child_total);
    }
}
