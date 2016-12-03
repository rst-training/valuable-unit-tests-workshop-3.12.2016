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
    public function calculate(Seat $seat, $price)
    {
        return $seat->getQuantity() * $price;
    }
}