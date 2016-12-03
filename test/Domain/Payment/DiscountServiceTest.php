<?php


namespace RstGroup\ConferenceSystem\Domain\Payment\Test;


use RstGroup\ConferenceSystem\Domain\Payment\AtLeastTenEarlyBirdSeatsDiscountStrategy;
use RstGroup\ConferenceSystem\Domain\Payment\DiscountService;
use RstGroup\ConferenceSystem\Domain\Payment\FreeSeatDiscountStrategy;
use RstGroup\ConferenceSystem\Domain\Payment\SeatDiscountStrategy;
use RstGroup\ConferenceSystem\Domain\Payment\SeatsStrategyConfiguration;
use RstGroup\ConferenceSystem\Domain\Reservation\Seat;

class DiscountServiceTest extends \PHPUnit_Framework_TestCase
{
//    /**
//     * @test
//     */
//    public function returns_price_discounted_by_15_percent_if_at_least_10_early_bird_seats_are_bought()
//    {
//        $configuration = $this->getMock(SeatsStrategyConfiguration::class);
//        $discountService = new DiscountService($configuration);
//        $seat = $this->getMockBuilder(Seat::class)->disableOriginalConstructor()->getMock();
//
//        $configuration->expects($this->at(0))->method('isEnabledForSeat')->with(AtLeastTenEarlyBirdSeatsDiscountStrategy::class)->willReturn(true);
//        $configuration->expects($this->at(1))->method('isEnabledForSeat')->with(FreeSeatDiscountStrategy::class)->willReturn(false);
//        $seat->expects($this->exactly(2))->method('getQuantity')->willReturn(10);
//
//        $this->assertEquals(59.5, $discountService->calculateForSeat($seat, 7), 0.01);
//    }

    /**
     * @test
     */
    public function returns_price_discounted_by_15_percent_if_at_least_10_early_bird_seats_are_bought()
    {
        $configuration = $this->getMock(SeatsStrategyConfiguration::class);
        $configuration->method('isEnabledForSeat')->willReturn(true);

        $seat = $this->getMockBuilder(Seat::class)->disableOriginalConstructor()->getMock();
        $seat->method('getQuantity')->willReturn(10);

        $discountService = new DiscountService([new AtLeastTenEarlyBirdSeatsDiscountStrategy($configuration)]);


        $this->assertEquals(170, $discountService->calculateForSeat($seat, 20));

    }
}
