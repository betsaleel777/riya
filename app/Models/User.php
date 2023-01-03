<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'admin',
        'avatar',
        'adresse',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'admin' => 'boolean',
    ];

    const RULES = [
        'name' => 'required|unique:users,name|max:60',
        'email' => 'required|unique:users,email',
        'password' => 'required|confirmed|min:6',
        'password_confirmation' => 'required',
        'avatar' => 'required|image|mimes:jpeg,png,svg',
    ];

    const MESSAGES = [
        'name.unique' => 'Ce nom est déjà utilisé.',
        'name.required' => 'Le nom est requis.',
        'password.required' => 'Le mot de passe est requis.',
        'password_confirmation' => 'Veuillez confirmer le mot de passe.',
        'avatar.required' => 'Une image est requise.',
        'avatar.size' => "La taille de l'image doit être inférieure à 4M.",
        'avatar.mimes' => "Les formats requis sont PNG,JPEG,SVG et JPG.",
        'avatar.image' => "L'avatar de l'utilisateur doit être une image.",
        'phone.unique' => "Ce numéro de téléphone est déjà utilisé.",
    ];

    public static function editRules(int $id, Bool $password): array
    {
        return $password ?
        [
            'name' => 'required|max:60|unique:users,name,' . $id,
            'email' => 'required|unique:users,email,' . $id,
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required',
        ]
        : [
            'name' => 'required|max:60|unique:users,name,' . $id,
            'email' => 'required|unique:users,email,' . $id,
            'phone' => 'nullable|unique:users,phone,' . $id,
        ];
    }
}
