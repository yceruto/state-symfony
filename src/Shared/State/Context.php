<?php

declare(strict_types=1);

namespace App\Shared\State;

interface Context
{
    public function changeState(State $state): void;
}
