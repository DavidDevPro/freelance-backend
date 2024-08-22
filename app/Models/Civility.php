<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Civility extends Model
{
    use HasFactory;

    // Définir la table associée (si le nom de la table ne suit pas la convention Laravel)
    protected $table = 'civility';

    // Définir la clé primaire (si elle n'est pas nommée 'id')
    protected $primaryKey = 'idCivility';

    // Définir les attributs qui peuvent être remplis via l'attribut de remplissage de Laravel
    protected $fillable = ['shortLabel', 'longLabel'];
}
