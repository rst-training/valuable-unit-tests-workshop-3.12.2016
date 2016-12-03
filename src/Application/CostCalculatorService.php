<?php

namespace RstGroup\ConferenceSystem\Application;

use RstGroup\ConferenceSystem\Domain\Payment\DiscountService;
use RstGroup\ConferenceSystem\Infrastructure\Reservation\ConferenceSeatsDao;
use RstGroup\ConferenceSystem\Domain\Reservation\Reservation;

class CostCalculatorService
{
    protected $discountService;
    protected $conferenceDao;

    public function __construct(
        DiscountService $discountService,
        ConferenceSeatsDao $conferenceSeatsDao
    ) {
        $this->discountService = $discountService;
        $this->conferenceDao = $conferenceSeatsDao;
    }

    public function getTotalCost(Reservation $reservation)
    {
        return 100;
    }
}
