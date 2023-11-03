<?php

namespace Tracking51;

use Tracking51\Interfaces\AirWaybillsInterface;

class AirWaybills implements AirWaybillsInterface {

    use Request;

    private $apiModule;

    public function createAnAirWayBill($params = [])
    {
        if (empty($params['awb_number'])) {
            throw new Tracking51Exception(ErrorMessages::ErrMissingAwbNumber);
        }
        if(!preg_match('/^\d{3}[ -]?(\d{8})$/',$params['awb_number'])){
            throw new Tracking51Exception(ErrorMessages::ErrInvalidAirWaybillFormat);
        }
        $this->apiPath = 'awb';
        $response = $this->sendApiRequest($params,'POST');
        return $response;
    }

}
