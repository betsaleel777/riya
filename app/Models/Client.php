<?php

namespace App\Models;

use App\Enums\ClientsStatus;
use App\StateMachines\ClientStatusStateMachine;
use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes, HasStateMachines;
    protected $fillable = ['nom_complet', 'type_client_id', 'telephone', 'email', 'cni', 'etat'];

    protected $dates = ['created_at'];
    const CRITERES = [
        'nom_complet' => 'Nom complet',
        'email' => 'Email',
        'telephone' => 'Téléphone',
        'created_at' => 'Date de création'
    ];

    const RULES = [
        'nom_complet' => 'required|max:200',
        'telephone' => 'required|unique:clients,telephone',
        'email' => 'nullable|unique:clients,email',
        'cni' => 'required|unique:clients,cni',
    ];

    const MESSAGES = [
        'nom_complet.required' => 'Le nom complet est requis.',
        'telephone.required' => 'Le numéro de téléphone est requis.',
        'email.unique' => 'Cette adresse email est déjà utilisée.',
        'cni.required' => 'La CNI est requise.',
        'cni.unique' => 'Cette CNI est déjà utilisée.'
    ];

    public static function editRules(int $id): array
    {
        return [
            'nom_complet' => 'required|max:200',
            'telephone' => 'required|unique:clients,telephone,' . $id,
            'email' => 'nullable|unique:clients,email,' . $id,
            'cni' => 'required|unique:clients,cni,' . $id,
        ];
    }

    public $stateMachines = [
        'etat' => ClientStatusStateMachine::class
    ];

    public function uptodate(): void
    {
        $this->etat()->toTransition(to: ClientsStatus::A_JOUR->value, responsible: auth()->user());
    }

    public function notUptodate(): void
    {
        $this->etat()->toTransition(to: ClientsStatus::PAS_A_JOUR->value, responsible: auth()->user());
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(TypeClient::class, 'type_client_id');
    }
}
