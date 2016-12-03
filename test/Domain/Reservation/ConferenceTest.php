<?php

namespace RstGroup\ConferenceSystem\Domain\Reservation\Test;

use RstGroup\ConferenceSystem\Domain\Reservation\ConferenceId;
use RstGroup\ConferenceSystem\Domain\Reservation\OrderId;
use RstGroup\ConferenceSystem\Domain\Reservation\Reservation;
use RstGroup\ConferenceSystem\Domain\Reservation\ReservationAlreadyExist;
use RstGroup\ConferenceSystem\Domain\Reservation\ReservationDoesNotExist;
use RstGroup\ConferenceSystem\Domain\Reservation\ReservationId;
use RstGroup\ConferenceSystem\Domain\Reservation\ReservationsCollection;
use RstGroup\ConferenceSystem\Domain\Reservation\Seat;
use RstGroup\ConferenceSystem\Domain\Reservation\SeatsAvailabilityCollection;
use RstGroup\ConferenceSystem\Domain\Reservation\SeatsCollection;
use RstGroup\ConferenceSystem\Domain\Reservation\Conference;

class ConferenceTest extends \PHPUnit_Framework_TestCase
{
    public function testMakeReservationForCorrectOrderId()
    {
        $this->markTestSkipped();
    }

    public function testMakeReservationForIncorrectOrderId()
    {
        $this->markTestSkipped();
    }

    public function testExecuteMakeReservationForOrderWithInvalidParameters()
    {
        $this->markTestSkipped();
    }

    public function testMakeReservationForExistingOrderId()
    {
        $this->markTestSkipped();
    }

    public function testMakeReservationForUnexistingOrderId()
    {
        $this->markTestSkipped();
    }

    public function testMakeReservationForEmptySeatsCollection()
    {
        $this->markTestSkipped();
    }

    public function testMakeReservationForSeatsAvailabilityGreaterThanSeatQuantity()
    {
        $this->markTestSkipped();
    }

    public function testMakeReservationForSeatsAvailabilityLowerThanSeatQuantity()
    {
        $this->markTestSkipped();
    }

    public function testMakeReservationForInvalidConferenceId()
    {
        $this->markTestSkipped();
    }
}
