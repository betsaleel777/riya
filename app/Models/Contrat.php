<?php

namespace App\Models;

use App\Enums\ContratStatus;
use App\StateMachines\ContratStateMachine;
use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;


class Contrat extends Model
{
    use HasStateMachines;

    protected $fillable = ['reference', 'debut', 'fin', 'client_id', 'status'];

    protected $dates = ['debut', 'fin', 'created_at'];
    const CRITERES = [
        'status' => 'Statut',
        'debut' => 'Date de début',
        'fin' => 'Date de fin',
        'created_at' => 'Date de création'
    ];
    const RULES = [
        'debut' => 'required',
        'fin' => 'required',
        'client_id' => 'required',
        'possedable_id' => 'required'
    ];

    const MESSAGES = [
        'debut.required' => "La date de début du contrat est requise",
        'fin.required' => "La date de fin du contrat est requise",
        'client_id.required' => "Le client est requis.",
        'possedable_id.required' => "Le bien est requis.",
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'debut' => 'date',
        'fin' => 'date',
    ];

    public $stateMachines = [
        'status' => ContratStateMachine::class
    ];

    protected function possedableType(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Str::of($value)->afterLast('\\'),
        );
    }

    public function codeGenerate(): void
    {
        $rang = $this->count() + 1;
        $this->attributes['reference'] = CONTRAT_CODE_PREFIXE . str_pad((string) $rang, DEFAULT_PAD_LEFT_NUMBER, '0', STR_PAD_LEFT);
    }

    public function isValid(): bool
    {
        return $this->status()->is(ContratStatus::VALIDATED->value);
    }

    public function isUnvalid(): bool
    {
        return $this->status()->is(ContratStatus::UNVALIDATED->value);
    }

    public function isAborted(): bool
    {
        return $this->status()->is(ContratStatus::ABORTED->value);
    }

    public function possedable(): MorphTo
    {
        return $this->morphTo();
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
