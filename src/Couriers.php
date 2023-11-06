<?php

namespace Tracking51;


use Tracking51\Interfaces\CouriersInterface;

class Couriers implements CouriersInterface {

    use Request;

    private $apiModule = 'couriers';

    public function getAllCouriers()
    {
        $this->apiPath = 'all';
        $response = $this->sendApiRequest();
        return $response;
    }


}
