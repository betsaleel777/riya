<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loyer extends Model
{
    protected $fillable = ['mois', 'montant', 'contrat_id'];

    protected $casts = [
        'montant' => 'integer',
        'mois' => 'date',
    ];

    const RULES = [
        'mois' => 'required',
        'montant' => 'required|required',
        'contrat_id' => 'required'
    ];

    const MESSAGES = [
        'mois.required' => "Le mois est requis.",
        'montant.required' => "Le montant est requise.",
        'montant.numeric' => "Le montant doit être numérique.",
        'contrat_id.required' => "Le contrat est requis.",
    ];

    public function contrat(): BelongsTo
    {
        return $this->belongsTo(Contrat::class);
    }
}
