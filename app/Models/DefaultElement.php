<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultElement extends Model
{
    use HasFactory;

    // Définir la table associée
    protected $table = 'default_elements';

    // Définir la clé primaire
    protected $primaryKey = 'idDefaultElement';

    // Définir les champs remplissables
    protected $fillable = ['name', 'description', 'idFormula'];

    // Relation avec Formula
    public function formula()
    {
        return $this->belongsTo(Formula::class, 'idFormula', 'idFormula');
    }
}
