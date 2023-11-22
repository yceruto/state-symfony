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
use App\Booking\Model\Request;
use App\Shared\State\BaseState;
use App\Shared\State\State;
use LogicException;
use Symfony\Component\Workflow\WorkflowInterface;

class PlannedOpenSideWaitingState extends BaseState
{
    public function __construct(
        private readonly State $plannedOpenSidePendingState,
        private readonly State $plannedOpenSideRejectedState,
        private readonly WorkflowInterface $requestStateMachine,
    ) {
    }

    public function process(Request $request): ?Booking
    {
        if (null === $doctor = $request->doctor()) {
            throw new LogicException('A doctor is required');
        }

        if (null === $date = $request->date()) {
            throw new LogicException('A date is required');
        }

        if (!$doctor->calendar()->isAvailableOn($date)) {
            // auto-rejected if there is no availability for the selected Doctor
            $this->requestStateMachine->apply($request, 'reject');

            $this->context->changeState($this->plannedOpenSideRejectedState);

            return null;
        }

        $this->requestStateMachine->apply($request, 'complete');

        $this->context->changeState($this->plannedOpenSidePendingState);

        return Booking::create($request->client(), $doctor, $date, $request);
    }
}
