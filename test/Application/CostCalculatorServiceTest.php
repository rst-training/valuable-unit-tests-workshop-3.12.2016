<?php

namespace RstGroup\ConferenceSystem\Application;

use RstGroup\ConferenceSystem\Application\CostCalculatorService;
use RstGroup\ConferenceSystem\Domain\Reservation\Reservation;

class CostCalculatorServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function verifyCalculationOfTotalCostWithDiscount()
    {
        $conferenceSeatsDaoMock = $this->getMockBuilder('\RstGroup\ConferenceSystem\Infrastructure\Reservation\ConferenceSeatsDao')
            ->disableOriginalConstructor()
            ->getMock();
        $discountServiceMock = $this->getMockBuilder('\RstGroup\ConferenceSystem\Domain\Payment\DiscountService')
            ->disableOriginalConstructor()
            ->getMock();
        $reservationIdMock = $this->getMockBuilder('\RstGroup\ConferenceSystem\Domain\Reservation\ReservationId')
            ->disableOriginalConstructor()
            ->getMock();
        $seatsCollectionMock = $this->getMockBuilder('\RstGroup\ConferenceSystem\Domain\Reservation\SeatsCollection')
            ->disableOriginalConstructor()
            ->getMock();

        $costCalculatorService = new CostCalculatorService($discountServiceMock, $conferenceSeatsDaoMock);

        $reservation = new Reservation($reservationIdMock, $seatsCollectionMock);
        $totalCost = $costCalculatorService->getTotalCost($reservation);

        $expectedTotalCost = 100;
        $this->assertEquals($expectedTotalCost, $totalCost);
    }
}
