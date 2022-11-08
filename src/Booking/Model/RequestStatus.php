<?php

declare(strict_types=1);

namespace App\Booking\Model;

enum RequestStatus: string
{
    case DRAFT = 'draft';
    case WAITING = 'waiting';
    case REJECTED = 'rejected';
    case COMPLETE = 'complete';

    public function isDraft(): bool
    {
        return $this === self::DRAFT;
    }

    public function isWaiting(): bool
    {
        return $this === self::WAITING;
    }

    public function isRejected(): bool
    {
        return $this === self::REJECTED;
    }

    public function isComplete(): bool
    {
        return $this === self::COMPLETE;
    }
}
