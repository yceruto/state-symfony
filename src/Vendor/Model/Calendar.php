<?php

declare(strict_types=1);

namespace App\Vendor\Model;

use DateTimeImmutable;

class Calendar
{
    /**
     * @param list<Availability> $availabilities
     */
    public function __construct(
        private readonly array $availabilities,
    ) {
    }

    public function availabilities(): iterable
    {
        foreach ($this->availabilities as $availability) {
            if ($availability->isAvailable()) {
                yield $availability;
            }
        }
    }

    public function isAvailableOn(DateTimeImmutable $date): bool
    {
        foreach ($this->availabilities as $availability) {
            if ($availability->isAvailable() && $availability->equals($date)) {
                return true;
            }
        }

        return false;
    }

    public function nextAvailability(): ?Availability
    {
        foreach ($this->availabilities as $availability) {
            if ($availability->isAvailable()) {
                return $availability;
            }
        }

        return null;
    }

    public function makeDateAvailable(DateTimeImmutable $date): void
    {
        foreach ($this->availabilities as $availability) {
            if ($availability->isUnavailable() && $availability->equals($date)) {
                $availability->enable();
                break;
            }
        }
    }

    public function makeDateUnavailable(DateTimeImmutable $date): void
    {
        foreach ($this->availabilities as $availability) {
            if ($availability->isAvailable() && $availability->equals($date)) {
                $availability->disable();
                break;
            }
        }
    }
}
