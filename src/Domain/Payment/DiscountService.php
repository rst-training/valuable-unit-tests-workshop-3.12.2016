<?php

namespace RstGroup\ConferenceSystem\Domain\Payment;

use RstGroup\ConferenceSystem\Domain\Payment\SeatDiscountStrategy;

class DiscountService
{
    public function calculateForSeat($seat, $price, array $discountStragegies = [])
    {
        $discountedPrice = null;

        foreach ($discountStragegies as $strategy) {
            if ($strategy instanceof SeatDiscountStrategy) {
                $discountedPrice = $strategy->calculate($seat, $price, $discountedPrice);
            }
        }

        return $discountedPrice;
    }
}
