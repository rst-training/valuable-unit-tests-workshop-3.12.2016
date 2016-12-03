<?php


namespace RstGroup\ConferenceSystem\Domain\Payment;


use RstGroup\ConferenceSystem\Domain\Payment\SeatDiscountStrategy;
use RstGroup\ConferenceSystem\Domain\Reservation\Seat;

class DiscountPoolStrategy implements SeatDiscountStrategy
{

    /**
     * @param $seat
     * @param $price
     * @return mixed discounted price
     */
    public function calculate(Seat $seat, $price)
    {
        return $seat->getQuantity() * $price;
    }
}