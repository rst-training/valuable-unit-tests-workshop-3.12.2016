<?php


namespace Application;


use PHPUnit_Framework_TestCase;
use RstGroup\ConferenceSystem\Application\RegistrationService;
use RstGroup\ConferenceSystem\Domain\Payment\PaypalPayments;
use RstGroup\ConferenceSystem\Domain\Reservation\Conference;
use RstGroup\ConferenceSystem\Domain\Reservation\Test\ConferenceTest;

class RegistrationServiceTest extends PHPUnit_Framework_TestCase
{
//    /** @test */
    public function calculationOfTotalCostWithDiscount() {

        $registrationService = new RegistrationService();
        $conferenceMock = $this->getMock(Conference::class);
        $conferenceMock->expects($this->once())
            ->method();

        $paypalPaymentsMock = $this->getMock(PaypalPayments::class);
        $paypalPaymentsMock->expects( $this->once() )
            ->method('getApprovalLink')
            ->with($this->anything(), 100.00)
            ->will($this->returnValue(''));


    }

    /** @test */
    public function calculateTotalCostExpetcsReturnCalculatedTotalCost() {

        /** @var Conference $conferenceMock */
        $conferenceMock = $this->getMockBuilder(Conference::class)->disableOriginalConstructor()->getMock();
        $conferenceMock->expects($this->once())
            ->method('calculateTotalCost')
            ->willReturn(500.00);

        $result = $conferenceMock->calculateTotalCost();

        $this->assertEquals(500.00, $result);
    }

}