<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Tracking51\Couriers;
use Tracking51\Tracking51Exception;
use Tracking51\Trackings;

class TrackingsTest extends TestCase
{

    /** @var Couriers */
    private $trackings;

    protected function setUp()
    {
        parent::setUp();
        $this->trackings = new Trackings('you api key');
    }

    /** @tests */
    public function testApiKeysExist(){
        try {
            new Trackings();
        } catch (Tracking51Exception $e) {
            $this->assertInstanceOf(Tracking51Exception::class, $e);
            $this->assertEquals($e->getMessage(), 'API Key is missing');
        }
    }

    /** @tests */
    public function testCreateTracking()
    {
        $params = ['tracking_number'=>'9400111899562537624646','courier_code'=>'usps'];
        $response = $this->trackings->createTracking($params);
        $this->assertInternalType('array',$response);
    }

    /** @tests */
    public function testGetTrackingResults()
    {
        $params = ['tracking_numbers'=>'92612903029511573030094532','courier_code'=>'usps'];
        $response = $this->trackings->getTrackingResults($params);
        $this->assertInternalType('array', $response);
    }

    /** @tests */
    public function testBatchCreateTrackings()
    {
        $params = [
            ['tracking_number'=>'92612903029511573030094531','courier_code'=>'usps'],
            ['tracking_number'=>'92612903029511573030094532','courier_code'=>'usps']
        ];
        $response = $this->trackings->batchCreateTrackings($params);
        $this->assertInternalType('array', $response);
    }

    /** @tests */
    public function testUpdateTrackingByID()
    {
        $params = ['customer_name'=>'New name','note'=>'New tests order note'];
        $idString = '9a035f5cdd0437c55d48e223c705a66c';
        $response = $this->trackings->updateTrackingByID($idString, $params);
        $this->assertInternalType('array', $response);
    }

    /** @tests */
    public function testDeleteTrackingByID()
    {
        $idString = '99f8a21408be0b436705aa84d6f91806';
        $response = $this->trackings->deleteTrackingByID($idString);
        $this->assertInternalType('array', $response);
    }

    /** @tests */
    public function testRetrackTrackingByID()
    {
        $idString = '9a035f5cdd0437c55d48e223c705a66c';
        $response = $this->trackings->retrackTrackingByID($idString);
        $this->assertInternalType('array', $response);
    }

    /** @tests */
    public function testBatchCreateTrackingsUpTo40()
    {
        $array = [];
        for($i=0;$i<41;$i++){
            $array[] = ['tracking_number'=>'9261290302951157303009453'.$i,'courier_code'=>'usps'];
        }
        $this->throwsError('batchCreateTrackings', [$array], 'Max. 40 tracking numbers create in one call');
    }

    /** @tests */
    public function testBatchCreateTrackingWithMissingTrackingNumber()
    {
        $array = [['tracking_number'=>'','courier_code'=>'usps']];
        $this->throwsError('batchCreateTrackings', [$array], 'Tracking number cannot be empty');
    }

    /** @tests */
    public function testBatchCreateTrackingWithMissingCourierCode()
    {
        $array = [['tracking_number'=>'9261290302951157303009453','courier_code'=>'']];
        $this->throwsError('batchCreateTrackings', [$array], 'Courier Code cannot be empty');
    }

    /** @tests */
    public function testUpdateTrackingByIDWithEmptyID()
    {
        $this->throwsError('updateTrackingByID', [''], 'Id cannot be empty');
    }

    /** @tests */
    public function testDeleteTrackingByIDWithEmptyID()
    {
        $this->throwsError('deleteTrackingByID', [''], 'Id cannot be empty');
    }

    /** @tests */
    public function testRetrackTrackingByIDWithEmptyID()
    {
        $this->throwsError('retrackTrackingByID', [''], 'Id cannot be empty');
    }


    /** @test */
    public function testCreateTrackingWithEmptyTrackingNumber()
    {
        $params = ['courier_code'=>'XYZ'];
        $this->throwsError('createTracking', [$params], 'Tracking number cannot be empty');
    }

    /** @test */
    public function testCreateTrackingWithEmptyCourierCode()
    {
        $params = ['tracking_number'=>'123456'];
        $this->throwsError('createTracking', [$params], 'Courier Code cannot be empty');
    }

    private function throwsError($method, $args, $errorMessage)
    {

        try {
            call_user_func_array([$this->trackings, $method], $args);
        } catch (\Exception $e) {
            $this->assertInstanceOf(Tracking51Exception::class, $e);
            $this->assertEquals($e->getMessage(), $errorMessage);
        }
    }

}