<?php

namespace App\StateMachines;

use App\Enums\ContratStatus;
use Asantibanez\LaravelEloquentStateMachines\StateMachines\StateMachine;

class ContratStateMachine extends StateMachine
{
    public function recordHistory(): bool
    {
        return true;
    }

    public function transitions(): array
    {
        return [
            ContratStatus::UNVALIDATED->value => ContratStatus::VALIDATED->value,
            ContratStatus::VALIDATED->value => ContratStatus::ABORTED->value
        ];
    }

    public function defaultState(): ?string
    {
        return ContratStatus::UNVALIDATED->value;
    }
}
