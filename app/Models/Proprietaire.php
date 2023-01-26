<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proprietaire extends Model
{
    use SoftDeletes;
    protected $fillable = ['nom_complet', 'cni', 'telephone', 'email', 'commission_terrain', 'commission_appartement'];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'commission_terrain' => 'integer',
        'commission_appartement' => 'integer',
    ];

    const RULES = [
        'nom_complet' => 'required|max:200',
        'telephone' => 'required|unique:proprietaires,telephone',
        'email' => 'nullable|unique:proprietaires,email',
        'cni' => 'required|unique:proprietaires,cni',
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
            'telephone' => 'required|unique:proprietaires,telephone,' . $id,
            'email' => 'nullable|unique:proprietaires,email,' . $id,
            'cni' => 'required|unique:proprietaires,cni,' . $id,
        ];
    }
}
