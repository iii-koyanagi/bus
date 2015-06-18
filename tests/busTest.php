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

    public function testEditData()
    {
        $data = '210:Cn,In,Iw,Ap,Iw';
        $bus = new bus();
        $edit_data = $bus->editData($data);
        $assert_edit_data = array(0 => '210', 1 => array( 0 => 'Cn' , 1 => 'In', 2 => 'Iw', 3 => 'Ap', 4 => 'Iw'));
        $this->assertEquals($edit_data, $assert_edit_data);
    }

    public function testAdultsAndChildCalculate()
    {
        $bus = new bus();
        $edit_data = array(0 => '210', 1 => array( 0 => 'Cn' , 1 => 'In', 2 => 'Iw', 3 => 'Ap', 4 => 'Iw'));
        $adultsAndChildCalculate = $bus->adultsAndChildCalculate($edit_data);
        $assert_adultsAndChildCalculate = array(0 => 1, 1 => doubleval(110));
        $this->assertEquals($adultsAndChildCalculate, $assert_adultsAndChildCalculate);
    }

    public function testInfantCalculateAndAllTotal()
    {
        $bus = new bus();
        $assert_edit_data = array(0 => '210', 1 => array( 0 => 'Cn' , 1 => 'In', 2 => 'Iw', 3 => 'Ap', 4 => 'Iw'));
        $assert_adultsAndChildCalculate = array(0 => 1, 1 => doubleval(110));

        $price = $assert_edit_data[0];
        $passengersArray = $assert_edit_data[1];
        $adult_number = $assert_adultsAndChildCalculate[0];
        $adult_and_child_total = $assert_adultsAndChildCalculate[1];

        $total = $bus->infantCalculateAndAllTotal($price, $passengersArray, $adult_number, $adult_and_child_total);

        $this->assertEquals($total, 170);
    }

    public function testBus()
    {
        $test_arr = array(
            '210:Cn,In,Iw,Ap,Iw' => 170,
            '220:Cp,In' => 110,
            '230:Cw,In,Iw' => 240,
            '240:In,An,In' => 240,
            '250:In,In,Aw,In' => 260,
            '260:In,In,In,In,Ap' => 260,
            '270:In,An,In,In,Ip' => 410,
            '280:Aw,In,Iw,In' => 210,
            '200:An' => 200,
            '210:Iw' => 60,
            '220:Ap' => 0,
            '230:Cp' => 0,
            '240:Cw' => 60,
            '250:In' => 130,
            '260:Cn' => 130,
            '270:Ip' => 0,
            '280:Aw' => 140,
            '1480:In,An,In,In,In,Iw,Cp,Cw,In,Aw,In,In,Iw,Cn,Aw,Iw' => 5920,
            '630:Aw,Cw,Iw,An,An' => 1740,
            '340:Cn,Cn,Ip,Ap' => 340,
            '240:Iw,Ap,In,Iw,Aw' => 120,
            '800:Cw,An,Cn,Aw,Ap' => 1800,
            '1210:An,Ip,In,Iw,An,Iw,Iw,An,Iw,Iw' => 3630,
            '530:An,Cw,Cw' => 810,
            '170:Aw,Iw,Ip' => 90,
            '150:In,Ip,Ip,Iw,In,Iw,Iw,In,An,Iw,Aw,Cw,Iw,Cw,An,Cp,Iw' => 580,
            '420:Cn,Cw,Cp' => 320,
            '690:Cw,In,An,Cp,Cn,In' => 1220,
            '590:Iw,Iw,Cn,Iw,Aw,In,In,Ip,Iw,Ip,Aw' => 1200,
            '790:Cw,Cn,Cn' => 1000,
            '1220:In,In,An,An,In,Iw,Iw,In,In,Ip,In,An,Iw' => 4590,
            '570:Cw,Cn,Cp' => 440,
            '310:Cn,Cw,An,An,Iw,Cp,Cw,Cn,Iw' => 1100,
            '910:Aw,In,Iw,Iw,Iw,Iw,Iw,An,Cw,In' => 2290,
            '460:Iw,Cw,Cw,Cn' => 590,
            '240:Iw,Iw,In,Iw,In,In,Cn,In,An' => 780,
            '1240:In,In,In,Ap,In,Cw,Iw,Iw,Iw,Aw,Cw' => 2170,
            '1000:Iw,Ip,In,An,In,In,In,An,In,Iw,In,In,Iw,In,Iw,Iw,Iw,An' => 5500,
            '180:In,Aw,Ip,Iw,In,Aw,In,Iw,Iw,In' => 330,
            '440:In,Ip,Cp,Aw,Iw,In,An' => 660,
            '1270:Ap,In,An,Ip,In,Ip,Ip' => 1270);

        foreach ($test_arr as $key => $test) {
            $bus = new bus();
            $edit_data = $bus->editData($key);
            $adultsAndChildCalculate = $bus->adultsAndChildCalculate($edit_data);

            $price = $edit_data[0];
            $passengersArray = $edit_data[1];
            $adult_number = $adultsAndChildCalculate[0];
            $adult_and_child_total = $adultsAndChildCalculate[1];

            $total = $bus->infantCalculateAndAllTotal($price, $passengersArray, $adult_number, $adult_and_child_total);
            $this->assertEquals($total, $test);
        }
    }
}
