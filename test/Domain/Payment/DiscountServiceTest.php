<?php


namespace RstGroup\ConferenceSystem\Domain\Payment\Test;


use RstGroup\ConferenceSystem\Domain\Payment\AtLeastTenEarlyBirdSeatsDiscountStrategy;
use RstGroup\ConferenceSystem\Domain\Payment\DiscountService;
use RstGroup\ConferenceSystem\Domain\Payment\FreeSeatDiscountStrategy;
use RstGroup\ConferenceSystem\Domain\Payment\PoolDiscountStrategy;
use RstGroup\ConferenceSystem\Domain\Payment\SeatsStrategyConfiguration;
use RstGroup\ConferenceSystem\Domain\Reservation\Seat;

class DiscountServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function returns_price_discounted_by_15_percent_if_at_least_10_early_bird_seats_are_bought()
    {
        $configuration = $this->getMock(SeatsStrategyConfiguration::class);
        $discountService = new DiscountService($configuration);
        $seat = $this->getMockBuilder(Seat::class)->disableOriginalConstructor()->getMock();

        $map = [
            [FreeSeatDiscountStrategy::class, $seat, false],
            [AtLeastTenEarlyBirdSeatsDiscountStrategy::class, $seat, true],
        ];

        $configuration->method('isEnabledForSeat')->will($this->returnValueMap($map));

        $seat->method('getQuantity')->willReturn(10);

        $this->assertEquals(70 * 85 / 100, $discountService->calculateForSeat($seat, 7), '', 0.01);
    }

    /**
     * @test
     */
    public function returns_same_price_for_seat_when_pool_empty()
    {

        $poolDiscount = new PoolDiscountStrategy();
        $price = 100;
        $seat = new Seat(1, 100);
        $this->assertEquals($price * $seat->getQuantity(), $poolDiscount->calculate($seat, $price));
    }
}
