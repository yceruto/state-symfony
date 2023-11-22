<?php

declare(strict_types=1);

/*
 * This file is part of the Second package.
 *
 * © Second <contact@scnd.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Booking\State\PlannedOpenSide;

use App\Booking\Model\Booking;
use App\Shared\State\BaseState;
use App\Shared\State\State;
use LogicException;
use Symfony\Component\Workflow\WorkflowInterface;

class PlannedOpenSidePendingState extends BaseState
{
    public function __construct(
        private readonly State $plannedOpenSideAcceptedState,
        private readonly State $plannedOpenSideCancelledState,
        private readonly State $plannedOpenSideRefusedState,
        private readonly WorkflowInterface $bookingStateMachine,
    ) {
    }

    public function accept(Booking $booking): void
    {
        if (!$booking->status()->isPending()) {
            throw new LogicException('Unexpected booking status');
        }

        $this->bookingStateMachine->apply($booking, 'accept');

        $booking->doctor()->accept($booking);

        $this->context->changeState($this->plannedOpenSideAcceptedState);
    }

    public function cancel(Booking $booking): void
    {
        if ($this->bookingStateMachine->can($booking, 'cancel_pending')) {
            $this->bookingStateMachine->apply($booking, 'cancel_pending');
        } else {
            $this->bookingStateMachine->apply($booking, 'cancel_accepted');
        }

        $booking->doctor()->cancel($booking);

        $this->context->changeState($this->plannedOpenSideCancelledState);
    }

    public function refuse(Booking $booking): void
    {
        $this->bookingStateMachine->apply($booking, 'refuse');

        $booking->doctor()->refuse($booking);

        $this->context->changeState($this->plannedOpenSideRefusedState);
    }
}
