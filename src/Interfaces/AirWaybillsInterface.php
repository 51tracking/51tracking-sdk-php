<?php

namespace Tracking51\Interfaces;

interface AirWaybillsInterface
{

    /**
     * Create an air waybill.
     * @param array $params
     * @return mixed
     */
    public function createAnAirWayBill($params = []);

}