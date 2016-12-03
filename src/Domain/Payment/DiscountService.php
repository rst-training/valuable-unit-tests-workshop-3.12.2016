<?php

namespace RstGroup\ConferenceSystem\Domain\Payment;

class DiscountService
{
    private $discountStrategies;

    public function __construct(array $discountStrategies)
    {
        $this->discountStrategies = $discountStrategies;
    }

    public function calculateForSeat($seat, $price)
    {
        $discountedPrice = null;

        foreach ($this->discountStrategies as $strategy) {
            $discountedPrice = $strategy->calculate($seat, $price, $discountedPrice);
        }

        return $discountedPrice;
    }
}
