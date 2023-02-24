<?php

namespace App\StateMachines;

use App\Enums\FactureStatus;
use Asantibanez\LaravelEloquentStateMachines\StateMachines\StateMachine;

class FactureStateMachine extends StateMachine
{
    public function recordHistory(): bool
    {
        return true;
    }

    public function transitions(): array
    {
        return [
            FactureStatus::UNPAID->value => FactureStatus::PAID->value,
            FactureStatus::PAID->value => FactureStatus::UNPAID->value
        ];
    }

    public function defaultState(): string
    {
        return FactureStatus::UNPAID->value;
    }
}
