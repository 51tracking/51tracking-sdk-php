<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Tracking51\Couriers;
use Tracking51\Tracking51Exception;

class CouriersTest extends TestCase
{

    /** @var Couriers */
    private $couriers;

    protected function setUp()
    {
        parent::setUp();
        $this->couriers = new Couriers('you api key');
    }

    /** @tests */
    public function testApiKeysExist(){
        try {
            new Couriers();
        } catch (Tracking51Exception $e) {
            $this->assertInstanceOf(Tracking51Exception::class, $e);
            $this->assertEquals($e->getMessage(), 'API Key is missing');
        }
    }

    /** @tests */
    public function testGetAllCouriers()
    {
        $response = $this->couriers->getAllCouriers();
        $this->assertInternalType('array',$response);
    }

    /** @tests */
    public function testDetect()
    {
        $trackingNumber = 'ABC123456789';
        $response = $this->couriers->detect(['tracking_number' => $trackingNumber]);
        $this->assertInternalType('array', $response);
    }

    /** @test */
    public function testTrackingNumberCantBeEmpty()
    {
        $this->throwsError('detect', [''], 'Tracking number cannot be empty');
    }

    private function throwsError($method, $args, $errorMessage)
    {

        try {
            call_user_func_array([$this->couriers, $method], $args);
        } catch (\Exception $e) {
            $this->assertInstanceOf(Tracking51Exception::class, $e);
            $this->assertEquals($e->getMessage(), $errorMessage);
        }
    }

}