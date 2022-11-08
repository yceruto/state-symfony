<?php

declare(strict_types=1);

namespace App\Customer\Model;

use App\Booking\Model\Booking;

class Client
{
    private array $bookings = [];

    public function __construct(
        private readonly string $name,
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function addBooking(Booking $booking): void
    {
        $this->bookings[] = $booking;
    }

    public function bookings(): array
    {
        return $this->bookings;
    }
}
