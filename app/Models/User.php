<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, \App\Models\Concerns\NormalizesTextAttributes;

    protected $titleCaseAttributes = ['nombre', 'puesto'];

    protected $table = 'usuarios';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'usuario',
        'contrasena',
        'puesto',
        'roles_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'contrasena',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // no email verification field in this table
    ];

    /**
     * Get the password for authentication.
     */
    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    /**
     * Relación: Un usuario pertenece a un rol
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'roles_id');
    }
}
