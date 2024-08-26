<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Civility extends Model
{
    use HasFactory;

    // Définir la table associée
    protected $table = 'civilities';

    // Définir les attributs qui peuvent être remplis via l'attribut de remplissage de Laravel
    protected $fillable = ['shortLabel', 'longLabel'];
}
