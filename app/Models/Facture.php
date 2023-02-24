<?php

namespace App\Models;

use App\Enums\FactureStatus;
use App\StateMachines\FactureStateMachine;
use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Facture extends Model
{
    use HasStateMachines, SoftDeletes;
    protected $fillable = ['reference', 'status', 'echelonner'];

    protected $casts = [
        'echelonner' => 'boolean',
    ];

    protected $dates = ['created_at'];

    public $stateMachines = [
        'status' => FactureStateMachine::class
    ];

    protected function typableType(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Str::of($value)->afterLast('\\'),
        );
    }

    public function codeGenerate(string $type): void
    {
        $rang = $this->count() + 1;
        $this->attributes['reference'] = FACTURES_PREFIXES[$type] . str_pad((string) $rang, DEFAULT_PAD_LEFT_NUMBER, '0', STR_PAD_LEFT);
    }

    public function isPaid(): bool
    {
        return $this->status()->is(FactureStatus::PAID->value);
    }

    public function isUnpaid(): bool
    {
        return $this->status()->is(FactureStatus::UNPAID->value);
    }

    public function pourLoyer()
    {
        return Str::startsWith($this->attributes['reference'], FACTURE_LOYER_CODE_PREFIXE);
    }

    public function pourAchat()
    {
        return Str::startsWith($this->attributes['reference'], FACTURE_ACHAT_CODE_PREFIXE);
    }

    public function pourCaution()
    {
        return Str::startsWith($this->attributes['reference'], FACTURE_CAUTION_CODE_PREFIXE);
    }

    public function pourVisite()
    {
        return Str::startsWith($this->attributes['reference'], FACTURE_VISITE_CODE_PREFIXE);
    }

    public function scopePaid(Builder $query)
    {
        return $query->whereHasStatus(fn ($query) => $query->withTransition(FactureStatus::PAID->value));
    }

    public function scopeUnpaid(Builder $query)
    {
        return $query->whereHasStatus(fn ($query) => $query->withTransition(FactureStatus::UNPAID->value));
    }

    public function typable(): MorphTo
    {
        return $this->morphTo();
    }
}
