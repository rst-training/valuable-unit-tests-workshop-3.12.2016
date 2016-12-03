<?php


namespace RstGroup\ConferenceSystem\Domain\Payment\Test;


use RstGroup\ConferenceSystem\Domain\Payment\AtLeastTenEarlyBirdSeatsDiscountStrategy;
use RstGroup\ConferenceSystem\Domain\Payment\DiscountService;
use RstGroup\ConferenceSystem\Domain\Payment\SeatsStrategyConfiguration;
use RstGroup\ConferenceSystem\Domain\Reservation\Seat;

class DiscountServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function returns_price_discounted_by_15_percent_if_at_least_10_early_bird_seats_are_bought()
    {
        $configurationMock = $this->getMock(SeatsStrategyConfiguration::class);
        $configurationMock->method('isEnabledForSeat')
            ->will($this->returnValue(true));

        $discountService = new DiscountService();
        $discountStrategy = new AtLeastTenEarlyBirdSeatsDiscountStrategy($configurationMock);
        $seat = new Seat('Early bird seat', 10);
        $discountedPrice = $discountService->calculateForSeat($seat, 100, [$discountStrategy]);

        $this->assertEquals(850.0, $discountedPrice);
    }
}
