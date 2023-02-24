<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Caution extends Model
{
    protected $fillable = ['client_id', 'nombre_mois'];

    protected $casts = [
        'nombre_mois' => 'integer',
    ];

    const RULES = [
        'nombre_mois' => 'required|numeric',
        'client_id' => 'required',
        'possedable_id' => 'required'
    ];

    const MESSAGES = [
        'nombre_mois.required' => "Le montant est requise.",
        'nombre_mois.numeric' => "Le montant doit être numérique.",
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
