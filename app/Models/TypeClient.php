<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeClient extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['nom'];

    const RULES = [
        'nom' => 'required|unique:type_clients,nom|max:190',
    ];
    const MESSAGES = [
        'nom.required' => 'le champ nom est requis.',
        'nom.unique' => 'Ce nom est déjà utilisé.',
        'nom.max' => 'La limite maximum de 190 caractères a été dépassée.',
    ];
    public static function editRules(int $id)
    {
        return ['nom' => 'required|max:190|unique:type_clients,nom,' . $id];
    }
}
