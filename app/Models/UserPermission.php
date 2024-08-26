<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    // Indiquez la table associée au modèle (si le nom de la table n'est pas la convention par défaut)
    protected $table = 'user_permissions';

    // Indiquez la clé primaire si elle n'est pas 'id' (par défaut)
    protected $primaryKey = 'idUserPermission';

    // Si la clé primaire n'est pas auto-incrémentée ou si elle n'est pas de type 'int', spécifiez-le
    public $incrementing = true;
    protected $keyType = 'int';

    // Les champs qui peuvent être massivement assignés
    protected $fillable = [
        'labelPermission',
        'descriptionPermission',
        'isDefault',
        'active',
    ];

    // Définir les relations avec d'autres modèles si nécessaire
    public function users()
    {
        return $this->hasMany(User::class, 'idUserPermissions', 'idUserPermission');
    }
}
