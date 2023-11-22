<?php

declare(strict_types=1);

namespace App\Booking\Service;

use App\Booking\Model\Booking;
use App\Booking\Model\Request;
use App\Shared\State\Context;
use App\Shared\State\State;

class BookingStateMachine implements Context
{
    private State $state;

    public function __construct(
        State $initialState,
    ) {
        $this->changeState($initialState);
    }

    public function changeState(State $state): void
    {
        $this->state = $state;
        $state->setContext($this);
    }

    public function request(Request $request): void
    {
        $this->state->request($request);
    }

    public function process(Request $request): ?Booking
    {
        return $this->state->process($request);
    }

    public function cancel(Booking $booking): void
    {
        $this->state->cancel($booking);
    }

    public function refuse(Booking $booking): void
    {
        $this->state->refuse($booking);
    }

    public function accept(Booking $booking): void
    {
        $this->state->accept($booking);
    }

    public function execute(Booking $booking): void
    {
        $this->state->execute($booking);
    }

    public function finish(Booking $booking): void
    {
        $this->state->finish($booking);
    }
}
