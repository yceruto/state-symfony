<?php

declare(strict_types=1);

namespace App\Booking\Model;

use App\Customer\Model\Client;
use App\Vendor\Model\Doctor;
use DateTimeImmutable;
use LogicException;

class Request
{
    private RequestStatus $status = RequestStatus::DRAFT;

    public function __construct(
        private readonly Client $client,
        private readonly ?Doctor $doctor,
        private readonly ?DateTimeImmutable $date,
    ) {
    }

    public function client(): Client
    {
        return $this->client;
    }

    public function doctor(): ?Doctor
    {
        return $this->doctor;
    }

    public function date(): ?DateTimeImmutable
    {
        return $this->date;
    }

    public function status(): RequestStatus
    {
        return $this->status;
    }
}
