<?php
/**
 * Created by PhpStorm.
 * User: mleczakm
 * Date: 03.12.16
 * Time: 11:49
 */

namespace RstGroup\ConferenceSystem\Domain\Reservation\Test;


use RstGroup\ConferenceSystem\Application\RegistrationService;
use RstGroup\ConferenceSystem\Domain\Payment\AtLeastTenEarlyBirdSeatsDiscountStrategy;
use RstGroup\ConferenceSystem\Domain\Payment\DiscountService;
use RstGroup\ConferenceSystem\Domain\Payment\FreeSeatDiscountStrategy;
use RstGroup\ConferenceSystem\Domain\Payment\PaypalPayments;
use RstGroup\ConferenceSystem\Domain\Payment\SeatsStrategyConfiguration;
use RstGroup\ConferenceSystem\Domain\Reservation\Conference;
use RstGroup\ConferenceSystem\Domain\Reservation\ConferenceId;
use RstGroup\ConferenceSystem\Domain\Reservation\OrderId;
use RstGroup\ConferenceSystem\Domain\Reservation\Reservation;
use RstGroup\ConferenceSystem\Domain\Reservation\ReservationId;
use RstGroup\ConferenceSystem\Domain\Reservation\ReservationsCollection;
use RstGroup\ConferenceSystem\Domain\Reservation\Seat;
use RstGroup\ConferenceSystem\Domain\Reservation\SeatsAvailabilityCollection;
use RstGroup\ConferenceSystem\Domain\Reservation\SeatsCollection;
use RstGroup\ConferenceSystem\Infrastructure\Reservation\ConferenceMemoryRepository;
use RstGroup\ConferenceSystem\Infrastructure\Reservation\ConferenceSeatsDao;

class RegistrationServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function returns_response_with_approval_link_()
    {
        $registrationServiceMock = $this->getMock(RegistrationService::class);

        $conferenceRepository = new ConferenceMemoryRepository();

        $seats = new SeatsAvailabilityCollection();

        $conferenceId = new ConferenceId(1);

        $reservation = new Reservation(new ReservationId($conferenceId, new OrderId(1)), SeatsCollection::fromArray([new Seat(1, 100)]));

        $conferenceRepository->add(new Conference($conferenceId, $seats, new ReservationsCollection(), new ReservationsCollection()));

        $paypalPaymentsMock = $this->getMock(PaypalPayments::class);
        $paypalPaymentsMock->method('getApprovalLink')->will($this->returnArgument(2));

        $registrationServiceMock->method('getConferenceRepository')->willReturn($conferenceRepository);
        $registrationServiceMock->method('getPaypalPayments')->will($this->returnValue(function () use ($paypalPaymentsMock) {
            return $paypalPaymentsMock;
        }));

        ob_start();
        $registrationServiceMock->confirmOrder(1, 1);
        $result = ob_get_contents();
        ob_end_clean();

        var_dump($result);
    }

    /**
     * @test
     */
    public function returns_total_cost_of_reserved_seats_for_reservation_in_conference_with_discount()
    {

        $seatsStrategyConfiguration = $this->getMock(SeatsStrategyConfiguration::class);

        $seat = new Seat(1, 100);

        $map = [
            [FreeSeatDiscountStrategy::class, $seat, false],
            [AtLeastTenEarlyBirdSeatsDiscountStrategy::class, $seat, true],
        ];

        $seatsStrategyConfiguration->method('isEnabledForSeat')->will($this->returnValueMap($map));
        $discountService = new DiscountService($seatsStrategyConfiguration);

        $conferenceDaoMock = $this->getMockBuilder(ConferenceSeatsDao::class)
            ->disableOriginalConstructor()
            ->getMock();

        $conferenceDaoMock->method('getSeatsPrices')->willReturn([1 => [1]]);

        $registrationService = new RegistrationService($conferenceDaoMock, $discountService);
        $conferenceId = new ConferenceId(1);
        $seats = SeatsAvailabilityCollection::fromArray([$seat]);
        $conference = new Conference($conferenceId, $seats, new ReservationsCollection(), new ReservationsCollection());
        $reservation = new Reservation(new ReservationId($conferenceId, new OrderId(1)), SeatsCollection::fromArray([$seat]));

        $this->assertEquals(85, $registrationService->getTotalCostForReservation($reservation, $conference));
    }

}