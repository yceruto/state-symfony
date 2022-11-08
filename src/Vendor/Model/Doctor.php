<?php

declare(strict_types=1);

namespace App\Vendor\Model;

use App\Booking\Model\Booking;

class Doctor
{
    private array $bookings = [];

    public function __construct(
        private readonly string $name,
        private readonly Calendar $calendar,
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function calendar(): Calendar
    {
        return $this->calendar;
    }

    public function addBooking(Booking $booking): void
    {
        $this->bookings[] = $booking;
    }

    /**
     * @return list<Booking>
     */
    public function bookings(): array
    {
        return $this->bookings;
    }

    public function accept(Booking $booking): void
    {
        $this->calendar()->makeDateUnavailable($booking->date());
    }
}
