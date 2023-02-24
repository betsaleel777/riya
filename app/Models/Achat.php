<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Achat extends Model
{
    protected $fillable = ['client_id', 'montant', 'date'];

    protected $casts = [
        'montant' => 'integer',
        'date' => 'date',
    ];

    const RULES = [
        'montant' => 'required|numeric',
        'client_id' => 'required',
        'possedable_id' => 'required'
    ];

    const MESSAGES = [
        'montant.required' => "Le montant est requise.",
        'montant.numeric' => "Le montant doit être numérique.",
        'client_id.required' => "Le client est requis.",
        'possedable_id.required' => "Le bien est requis.",
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function possedable(): MorphTo
    {
        return $this->morphTo();
    }
}
