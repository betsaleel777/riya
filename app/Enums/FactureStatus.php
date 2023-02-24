<?php

namespace App\Enums;

enum FactureStatus: string
{
    case UNPAID = 'impayée';
    case PAID = 'soldée';
}
