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

namespace App\Booking\State;

use App\Booking\Model\Request;
use App\Shared\State\BaseState;
use App\Shared\State\State;
use Symfony\Component\Workflow\WorkflowInterface;

class DraftState extends BaseState
{
    public function __construct(
        private readonly State $plannedOpenSideWaitingState,
        private readonly State $plannedBlindSideWaitingState,
        private readonly State $onDemandOpenSideWaitingState,
        private readonly State $onDemandBlindSideWaitingState,
        private readonly WorkflowInterface $requestStateMachine,
    ) {
    }

    public function request(Request $request): void
    {
        $this->requestStateMachine->apply($request, 'request');

        if (null !== $request->doctor() && null !== $request->date()) {
            // Planned / Open-Side
            $this->context->changeState($this->plannedOpenSideWaitingState);
        } elseif (null !== $request->doctor() && null === $request->date()) {
            // On-Demand / Open-Side
            $this->context->changeState($this->onDemandOpenSideWaitingState);
        } elseif (null === $request->doctor() && null !== $request->date()) {
            // Planned / Blind-Side
            $this->context->changeState($this->plannedBlindSideWaitingState);
        } else {
            // On-Demand / Blind-Side
            $this->context->changeState($this->onDemandBlindSideWaitingState);
        }
    }
}
