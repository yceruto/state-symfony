<?php

declare(strict_types=1);

namespace App\Booking\Model;

enum BookingStatus: string
{
    case PENDING = 'pending';
    case CANCELLED = 'cancelled';
    case REFUSED = 'refused';
    case ACCEPTED = 'accepted';
    case EXECUTING = 'executing';
    case FINISHED = 'finished';

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
