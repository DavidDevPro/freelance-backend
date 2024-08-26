<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'identifiant',
        'email',
        'password',
        'urlPictureProfil',
        'user_permission_id',
        'isActive',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'user_permission_id' => 'integer',
        'isActive' => 'boolean',
    ];

    // Relation avec la table user_permissions
    public function userPermission()
    {
        return $this->belongsTo(UserPermission::class, 'user_permission_id', 'id');
    }

    public function isAdmin()
    {
        return $this->userPermission && strtolower($this->userPermission->labelPermission) === 'admin';
    }
}
