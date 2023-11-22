<?php

declare(strict_types=1);

namespace App\Booking\Model;

enum BookingStatus: string
{
    case PENDING = 'PENDING';
    case CANCELLED = 'CANCELLED';
    case REFUSED = 'REFUSED';
    case ACCEPTED = 'ACCEPTED';
    case EXECUTING = 'EXECUTING';
    case FINISHED = 'FINISHED';

    public function isPending(): bool
    {
        return $this === self::PENDING;
    }

    public function isCancelled(): bool
    {
        return $this === self::CANCELLED;
    }

    public function isRefused(): bool
    {
        return $this === self::REFUSED;
    }

    public function isAccepted(): bool
    {
        return $this === self::ACCEPTED;
    }

    public function isExecuting(): bool
    {
        return $this === self::EXECUTING;
    }

    public function isFinished(): bool
    {
        return $this === self::FINISHED;
    }
}
