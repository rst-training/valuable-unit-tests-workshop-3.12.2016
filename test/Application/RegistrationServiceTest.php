<?php


namespace Application;


use PHPUnit_Framework_TestCase;
use RstGroup\ConferenceSystem\Application\RegistrationService;
use RstGroup\ConferenceSystem\Domain\Payment\PaypalPayments;

class RegistrationServiceTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function calculationOfTotalCostWithDiscount() {

        $registrationService = new RegistrationService();
        $conferenceMock = $this->getMock('Conference');
        $conferenceMock->expects($this->once())
            ->method();

        $paypalPaymentsMock = $this->getMock('PaypalPayments');
        $paypalPaymentsMock->expects( $this->once() )
            ->method('getApprovalLink')
            ->with($this->anything(), 100.00)
            ->will($this->returnValue(''));


    }
}