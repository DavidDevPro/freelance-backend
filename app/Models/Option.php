<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    // Définir la table associée
    protected $table = 'options';

    // Définir la clé primaire
    protected $primaryKey = 'idOption';

    // Définir les champs remplissables
    protected $fillable = ['name', 'description', 'price', 'active'];

    // Relation avec Formula
    public function formulas()
    {
        return $this->belongsToMany(Formula::class, 'formula_options', 'idOption', 'idFormula')
            ->withTimestamps();
    }
}
