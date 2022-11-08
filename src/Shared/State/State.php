<?php

declare(strict_types=1);

namespace App\Shared\State;

use App\Booking\Model\Booking;
use App\Booking\Model\Request;

interface State
{
    public function request(Request $request): void;

    public function process(Request $request): ?Booking;

    public function cancel(Booking $booking): void;

    public function refuse(Booking $booking): void;

    public function accept(Booking $booking): void;

    public function execute(Booking $booking): void;

    public function finish(Booking $booking): void;

    public function setContext(Context $context): void;
}
