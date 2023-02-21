<?php

namespace App\Enums;

enum ContratStatus: string
{
    case VALIDATED = 'valide';
    case UNVALIDATED = 'invalide';
    case ABORTED = 'resilié';
}
