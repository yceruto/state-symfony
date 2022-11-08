<?php

declare(strict_types=1);

namespace App\Vendor\Model;

use DateTimeImmutable;
use Money\Money;

class Availability
{
    public function __construct(
        private readonly DateTimeImmutable $date,
        private readonly Money $money,
        private bool $available = true,
    ) {
    }

    public function date(): DateTimeImmutable
    {
        return $this->date;
    }

    public function money(): Money
    {
        return $this->money;
    }

    public function isAvailable(): bool
    {
        return $this->available && $this->date >= new DateTimeImmutable('today');
    }

    public function isUnavailable(): bool
    {
        return !$this->isAvailable();
    }

    public function equals(DateTimeImmutable $date): bool
    {
        return $this->date->format('Y-m-d') === $date->format('Y-m-d');
    }

    public function enable(): void
    {
        $this->available = true;
    }

    public function disable(): void
    {
        $this->available = false;
    }
}
