<?php

declare(strict_types=1);

namespace App\Booking\Model;

use App\Customer\Model\Client;
use App\Vendor\Model\Doctor;
use DateTimeImmutable;
use LogicException;

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

    public function cancel(): void
    {
        if (!$this->status->isPending() && !$this->status->isAccepted()) {
            throw new LogicException('Unexpected booking status.');
        }

        $this->status = BookingStatus::CANCELLED;
    }

    public function refuse(): void
    {
        if ($this->status->isPending()) {
            throw new LogicException('Unexpected booking status.');
        }

        $this->status = BookingStatus::REFUSED;
    }

    public function accept(): void
    {
        if (!$this->status->isPending()) {
            throw new LogicException('Unexpected booking status.');
        }

        $this->status = BookingStatus::ACCEPTED;
    }

    public function execute(): void
    {
        if (!$this->status->isAccepted()) {
            throw new LogicException('Unexpected booking status.');
        }

        $this->status = BookingStatus::EXECUTING;
    }

    public function finish(): void
    {
        if (!$this->status->isExecuting()) {
            throw new LogicException('Unexpected booking status.');
        }

        $this->status = BookingStatus::FINISHED;
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
