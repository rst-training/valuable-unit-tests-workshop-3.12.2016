<?php

namespace RstGroup\ConferenceSystem\Application;

use RstGroup\ConferenceSystem\Domain\Payment\PaypalPayments;
use RstGroup\ConferenceSystem\Domain\Reservation\ConferenceId;
use RstGroup\ConferenceSystem\Domain\Payment\DiscountService;
use RstGroup\ConferenceSystem\Domain\Reservation\OrderId;
use RstGroup\ConferenceSystem\Domain\Reservation\ReservationId;
use RstGroup\ConferenceSystem\Domain\Reservation\Seat;
use RstGroup\ConferenceSystem\Domain\Reservation\SeatsCollection;
use RstGroup\ConferenceSystem\Infrastructure\Reservation\ConferenceSeatsDao;
use RstGroup\ConferenceSystem\Infrastructure\Reservation\ConferenceMemoryRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RegistrationService
{
    protected $conferenceRepository;
    protected $conferenceDao;
    protected $discountService;
    protected $paypalPayments;
    protected $costCalculator;

    public function __construct(
        ConferenceMemoryRepository $conferenceMemoryRepository,
        ConferenceSeatsDao $conferenceSeatsDao,
        DiscountService $discountService,
        PaypalPayments $paypalPayments
    ) {
        $this->conferenceRepository = $conferenceMemoryRepository;
        $this->conferenceDao = $conferenceSeatsDao;
        $this->discountService = $discountService;
        $this->paypalPayments = $paypalPayments;
        $this->costCalculator = $costCalculator;
    }

    public function reserveSeats($orderId, $conferenceId, $seats)
    {
        $conference = $this->getConferenceRepository()->get(new ConferenceId($conferenceId));

        $seatsCollection = $this->fromArray($seats);

        $conference->makeReservationForOrder(new OrderId($orderId), $seatsCollection);
    }

    public function cancelReservation($orderId, $conferenceId)
    {
        $conference = $this->getConferenceRepository()->get(new ConferenceId($conferenceId));

        $conference->cancelReservationForOrder(new OrderId($orderId));
    }

    public function confirmOrder($orderId, $conferenceId)
    {
        $conference = $this->getConferenceRepository()->get(new ConferenceId($conferenceId));
        $reservation = $conference->getReservations()->get(new ReservationId(new ConferenceId($conferenceId), new OrderId($orderId)));

        $totalCost = 0;
        $seats = $reservation->getSeats();
        $seatsPrices = $this->getConferenceDao()->getSeatsPrices($conferenceId);

        foreach ($seats->getAll() as $seat) {
            $priceForSeat = $seatsPrices[$seat->getType()][0];

            $dicountedPrice = $this->getDiscountService()->calculateForSeat($seat, $priceForSeat);
            $regularPrice = $priceForSeat * $seat->getQuantity();

            $totalCost += min($dicountedPrice, $regularPrice);
        }

        $conference->closeReservationForOrder(new OrderId($orderId));

        $approvalLink = $this->getPaypalPayments()->getApprovalLink($conference, $totalCost);

        $response = new RedirectResponse($approvalLink);
        $response->send();
    }

    protected function fromArray($seats)
    {
        $seatsCollection = new SeatsCollection();

        foreach ($seats as $seat) {
            $seatsCollection->add(new Seat($seat['type'], $seat['quantity']));
        }

        return $seatsCollection;
    }
}