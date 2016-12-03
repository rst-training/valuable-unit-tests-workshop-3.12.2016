<?php

namespace RstGroup\ConferenceSystem\Application\Test;

use PHPUnit_Framework_TestCase;
use RstGroup\ConferenceSystem\Application\RegistrationService;
use RstGroup\ConferenceSystem\Domain\Payment\PaypalPayments;
use RstGroup\ConferenceSystem\Infrastructure\Reservation\ConferenceMemoryRepository;

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
}
