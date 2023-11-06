<?php

namespace Tracking51\Interfaces;

interface CouriersInterface
{

    /**
     * Return a list of all supported couriers.
     * @return mixed
     */
    public function getAllCouriers();


}