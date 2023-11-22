<?php

declare(strict_types=1);

namespace App\Booking\Model;

enum RequestStatus: string
{
    public const REQUEST_TRANSITION = 'request';
    public const REJECT_TRANSITION = 'reject';
    public const COMPLETE_TRANSITION = 'complete';

    case DRAFT = 'DRAFT';
    case WAITING = 'WAITING';
    case REJECTED = 'REJECTED';
    case COMPLETED = 'COMPLETED';

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

    public function isCompleted(): bool
    {
        return $this === self::COMPLETED;
    }
}
