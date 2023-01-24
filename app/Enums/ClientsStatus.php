<?php

namespace App\Enums;

enum ClientsStatus: string
{
    case SANS_CONTRAT = 'sans contrat';
    case A_JOUR = 'à jour';
    case PAS_A_JOUR = 'pas à jour';
}
