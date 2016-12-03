<?php

namespace RstGroup\ConferenceSystem\Application\Test;

use PHPUnit_Framework_TestCase;
use RstGroup\ConferenceSystem\Application\RegistrationService;
use RstGroup\ConferenceSystem\Domain\Payment\PaypalPayments;
use RstGroup\ConferenceSystem\Domain\Reservation\ConferenceId;
use RstGroup\ConferenceSystem\Domain\Reservation\Reservation;
use RstGroup\ConferenceSystem\Infrastructure\Reservation\ConferenceMemoryRepository;
use RstGroup\ConferenceSystem\Infrastructure\Reservation\ConferenceSeatsDao;

class RegistrationServiceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function returns_calculated_cost_with_discount()
    {
        $reservationServiceMock = $this->createMock(RegistrationService::class, ['getPaypalPayments', 'getConferenceRepository']);
        $payPayMock = $this->createMock(PaypalPayments::class);
        $conferenceRepositoryMock = $this->createMock(ConferenceMemoryRepository::class);

        $reservationServiceMock->method('getPaypalPayments')->willReturn($payPayMock);
        $reservationServiceMock->method('getConferenceRepository')->willReturn($conferenceRepositoryMock);

        $payPayMock->method('getApprovalLink')->with($this->any(), 10);

        $reservationServiceMock->confirmOrder(4,4);


    }

    public function returns_calculated_cost()
    {
        $reservationService = new RegistrationService();
        $conferenceMock = $this->getMockBuilder(ConferenceSeatsDao::class)->disableOriginalConstructor()->getMock();
        $reservationMock = $this->getMockBuilder(Reservation::class)->setMethods(['getSeats'])->getMock();
        $reservationMock->method('getSeats')->willReturnMap(['1' => 20, '2' => 40]);
        $conferenceMock->method('getSeatsPrices')->willReturnMap(['1' => 10, '2' => 15]);

        $this->assertEquals(20, $reservationService->countTotalCost($reservationMock, new ConferenceId(3), $conferenceMock));
    }
}
