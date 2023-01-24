<?php

namespace App\StateMachines;

use App\Enums\ClientsStatus;
use Asantibanez\LaravelEloquentStateMachines\StateMachines\StateMachine;

class ClientStatusStateMachine extends StateMachine
{
    public function recordHistory(): bool
    {
        return true;
    }

    public function transitions(): array
    {
        return [
            ClientsStatus::SANS_CONTRAT->value => [ClientsStatus::PAS_A_JOUR->value, ClientsStatus::A_JOUR],
            ClientsStatus::PAS_A_JOUR->value => ClientsStatus::A_JOUR->value,
            ClientsStatus::A_JOUR->value => ClientsStatus::PAS_A_JOUR->value,
        ];
    }

    public function defaultState(): ?string
    {
        return ClientsStatus::SANS_CONTRAT->value;
    }
}
