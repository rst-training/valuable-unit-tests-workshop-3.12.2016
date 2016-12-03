<?php

namespace RstGroup\ConferenceSystem\Application;

use RstGroup\ConferenceSystem\Domain\Payment\PaypalPayments;
use RstGroup\ConferenceSystem\Domain\Reservation\Conference;
use RstGroup\ConferenceSystem\Domain\Reservation\ConferenceId;
use RstGroup\ConferenceSystem\Domain\Payment\DiscountService;
use RstGroup\ConferenceSystem\Domain\Reservation\OrderId;
use RstGroup\ConferenceSystem\Domain\Reservation\Reservation;
use RstGroup\ConferenceSystem\Domain\Reservation\ReservationId;
use RstGroup\ConferenceSystem\Domain\Reservation\Seat;
use RstGroup\ConferenceSystem\Domain\Reservation\SeatsCollection;
use RstGroup\ConferenceSystem\Infrastructure\Reservation\ConferenceSeatsDao;
use RstGroup\ConferenceSystem\Infrastructure\Reservation\ConferenceMemoryRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RegistrationService
{
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

        $conference->closeReservationForOrder(new OrderId($orderId));
        $totalCost = $this->countTotalCost($reservation, $conferenceId, $this->getConferenceDao(), $this->getDiscountService());

        $approvalLink = $this->getPaypalPayments()->getApprovalLink($conference, $totalCost);

        $response = new RedirectResponse($approvalLink);
        $response->send();
    }

    /**
     * @param Reservation $reservation
     * @param ConferenceId $conferenceId
     * @param ConferenceSeatsDao $conferenceSeatsDao
     * @param DiscountService $discountService
     * @return int|mixed
     */
    public function countTotalCost(Reservation $reservation, ConferenceId $conferenceId, ConferenceSeatsDao $conferenceSeatsDao, DiscountService $discountService)
    {
        $totalCost = 0;
        $seats = $reservation->getSeats();
        $seatsPrices = $conferenceSeatsDao->getSeatsPrices($conferenceId);

        foreach ($seats->getAll() as $seat) {
            $priceForSeat = $seatsPrices[$seat->getType()][0];

            $dicountedPrice = $discountService->calculateForSeat($seat, $priceForSeat);
            $regularPrice = $priceForSeat * $seat->getQuantity();

            $totalCost += min($dicountedPrice, $regularPrice);
        }

        return $totalCost;
    }

    protected function fromArray($seats)
    {
        $seatsCollection = new SeatsCollection();

        foreach ($seats as $seat) {
            $seatsCollection->add(new Seat($seat['type'], $seat['quantity']));
        }

        return $seatsCollection;
    }

    protected function getConferenceRepository()
    {
        return new ConferenceMemoryRepository();
    }

    protected function getConferenceDao()
    {
        return new ConferenceSeatsDao(new \PDO('mysql:host=localhost;dbname=test', 'admin', 'test'));
    }

    protected function getDiscountService()
    {
        return new DiscountService();
    }

    protected function getPaypalPayments()
    {
        return new PaypalPayments();
    }
}