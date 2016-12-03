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
    /** @test */
    public function cancelReservationForOrderExpectThatReservationWillBeCanceledAndReleaseSeatsForAnotherWaitingReservation() {

    }

    /** @test TDD? */
    public function cancelReservationForOrderExpectThrowExceptionIfOrderNotExists() {

    }

    /** @test TDD? */
    public function cancelReservationForOrderExpectThatReservationWillBeCanceled() {

    }

    /** @test TDD? */
    public function cancelReservationForOrderExpectThatReleaseSeats() {

    }

    /** @test TDD? */
    public function cancelReservationForOrderExpectThatAvailableSeatsReservedForAnotherReservation() {

    }

    /** @test TDD? */
    public function cancelReservationForOrderExpectThatAvailableSeatsQuantityIsThaSameAsReservationCanceled() {

    }

}
