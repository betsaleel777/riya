<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Terrain extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'reference', 'nom', 'superficie', 'montant_location',
        'montant_investit', 'pays', 'ville', 'quartier',
        'proprietaire_id', 'attestation_villageoise', 'titre_foncier',
        'document_cession', 'arreter_approbation', 'type_terrain_id',
    ];

    protected $with = ['type', 'proprietaire'];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'attestation_villageoise' => 'boolean',
        'titre_foncier' => 'boolean',
        'document_cession' => 'boolean',
        'arreter_approbation' => 'boolean',
        'superficie' => 'integer',
        'montant_location' => 'integer',
        'montant_investit' => 'integer',
    ];

    const RULES = [
        'nom' => 'required|max:190',
        'superficie' => 'required|numeric',
        'montant_location' => 'required|numeric',
        'montant_investit' => 'required|numeric',
        'pays' => 'required|max:50',
        'ville' => 'required|max:50',
        'quartier' => 'required|max:70',
        'proprietaire_id' => 'required',
        'type_terrain_id' => 'required',
    ];

    const MESSAGES = [
        'nom.required' => 'Le nom est requis.',
        'nom.max' => 'Limite de caractère dépassée (190).',
        'superficie.required' => 'La superficie est requise.',
        'superficie.numeric' => 'La superficie doit être numérique.',
        'montant_location.required' => 'Le montant de location est requis.',
        'montant_location.numeric' => 'Le montant de location doit être numérique.',
        'montant_investit.required' => 'Le montant investit est requis.',
        'montant_investit.numeric' => 'Le montant investit doit être numérique.',
        'pays.required' => 'Le pays est requis.',
        'pays.max' => 'Limite de caractère dépassée (50).',
        'ville.required' => 'La ville est requise.',
        'ville.max' => 'Limite de caractère dépassée (50).',
        'quartier.required' => 'Le quartier est requis.',
        'quartier.max' => 'Limite de caractère dépassée (70).',
        'proprietaire_id.required' => 'Le propriétaire est requis.',
        'type_terrain_id.required' => 'Le type de terrain est requis.',
    ];

    public function codeGenerate(): void
    {
        $rang = $this->count() + 1;
        $this->attributes['reference'] = TERRAIN_CODE_PREFIXE . str_pad((string) $rang, 7, '0', STR_PAD_LEFT);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(TypeTerrain::class, 'type_terrain_id');
    }

    public function proprietaire(): BelongsTo
    {
        return $this->belongsTo(Proprietaire::class);
    }
}
