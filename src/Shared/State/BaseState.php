<?php

declare(strict_types=1);

namespace App\Shared\State;

use App\Booking\Model\Booking;
use App\Booking\Model\Request;
use RuntimeException;

abstract class BaseState implements State
{
    protected Context $context;

    public function request(Request $request): void
    {
        throw new RuntimeException('Forbidden operation.');
    }

    public function process(Request $request): ?Booking
    {
        throw new RuntimeException('Forbidden operation.');
    }

    public function cancel(Booking $booking): void
    {
        throw new RuntimeException('Forbidden operation.');
    }

    public function refuse(Booking $booking): void
    {
        throw new RuntimeException('Forbidden operation.');
    }

    public function accept(Booking $booking): void
    {
        throw new RuntimeException('Forbidden operation.');
    }

    public function execute(Booking $booking): void
    {
        throw new RuntimeException('Forbidden operation.');
    }

    public function finish(Booking $booking): void
    {
        throw new RuntimeException('Forbidden operation.');
    }

    public function setContext(Context $context): void
    {
        $this->context = $context;
    }
}
