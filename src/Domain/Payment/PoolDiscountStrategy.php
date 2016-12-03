<?php
/**
 * Created by PhpStorm.
 * User: mleczakm
 * Date: 03.12.16
 * Time: 16:07
 */

namespace RstGroup\ConferenceSystem\Domain\Payment;


use RstGroup\ConferenceSystem\Domain\Reservation\Seat;

class PoolDiscountStrategy
{
    private $discountsPool;

    public function __construct(array $discountsPool = array())
    {
        $this->discountsPool = $discountsPool;
    }

    public function calculate(Seat $seat, $price)
    {
        if (isset($this->discountsPool[$seat->getType()]) && $this->discountsPool[$seat->getType()] >= $seat->getQuantity()) {
            return $seat->getQuantity() * $price - 1;
        }

        return $seat->getQuantity() * $price;
    }
}