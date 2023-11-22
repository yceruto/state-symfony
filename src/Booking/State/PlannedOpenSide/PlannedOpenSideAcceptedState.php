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
use Symfony\Component\Workflow\WorkflowInterface;

class PlannedOpenSideAcceptedState extends BaseState
{
    public function __construct(
        private readonly State $plannedOpenSideExecutingState,
        private readonly WorkflowInterface $bookingStateMachine,
    ) {
    }

    public function execute(Booking $booking): void
    {
        $this->bookingStateMachine->apply($booking, 'execute');

        $booking->doctor()->execute($booking);

        $this->context->changeState($this->plannedOpenSideExecutingState);
    }
}
