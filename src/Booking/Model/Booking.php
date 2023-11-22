<?php

declare(strict_types=1);

namespace App\Booking\Model;

use App\Customer\Model\Client;
use App\Vendor\Model\Doctor;
use DateTimeImmutable;

class Booking
{
    private BookingStatus $status = BookingStatus::PENDING;

    public static function create(Client $client, Doctor $doctor, DateTimeImmutable $date, Request $request): self
    {
        return new self($client, $doctor, $date, $request);
    }

    public function client(): Client
    {
        return $this->client;
    }

    public function doctor(): Doctor
    {
        return $this->doctor;
    }

    public function date(): DateTimeImmutable
    {
        return $this->date;
    }

    public function request(): Request
    {
        return $this->request;
    }

    public function status(): BookingStatus
    {
        return $this->status;
    }

    private function __construct(
        private readonly Client $client,
        private readonly Doctor $doctor,
        private readonly DateTimeImmutable $date,
        private readonly Request $request,
    ) {
        $client->addBooking($this);
        $doctor->addBooking($this);
    }
}
