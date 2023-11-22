<?php

declare(strict_types=1);

namespace App\Vendor\Model;

use App\Booking\Model\Booking;
use LogicException;

class Doctor
{
    private array $bookings = [];
    private bool $busy = false;

    public function __construct(
        private readonly string $name,
        private readonly Calendar $calendar,
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function isBusy(): bool
    {
        return $this->busy;
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

    public function cancel(Booking $booking): void
    {
        $this->assertDoctorHasBooking($booking);

        if ($booking->status()->isAccepted()) {
            $this->calendar()->makeDateAvailable($booking->date());
        }
    }

    public function accept(Booking $booking): void
    {
        $this->assertDoctorHasBooking($booking);

        $this->calendar()->makeDateUnavailable($booking->date());
    }

    public function refuse(Booking $booking): void
    {
        $this->assertDoctorHasBooking($booking);
    }

    public function execute(Booking $booking): void
    {
        $this->assertDoctorHasBooking($booking);

        $this->busy = true;
    }

    public function finish(Booking $booking): void
    {
        $this->assertDoctorHasBooking($booking);

        $this->busy = false;
    }

    private function assertDoctorHasBooking(Booking $booking): void
    {
        if ($booking->doctor() !== $this) {
            throw new LogicException(sprintf('The Booking #0 is booked for Doctor %s', $this->name));
        }
    }
}
