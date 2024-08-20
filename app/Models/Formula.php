<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formula extends Model
{
    use HasFactory;

    // Définir la table associée
    protected $table = 'formulas';

    // Définir la clé primaire
    protected $primaryKey = 'idFormula';

    // Définir les champs remplissables
    protected $fillable = ['name', 'description', 'basePrice', 'popular', 'active'];

    // Relations

    // Relation avec DefaultElement via la table pivot formula_defaults
    public function defaultElements()
    {
        return $this->belongsToMany(DefaultElement::class, 'formula_defaults', 'idFormula', 'idDefaultElement')
            ->withTimestamps();
    }

    // Relation avec Option via la table pivot formula_options
    public function options()
    {
        return $this->belongsToMany(Option::class, 'formula_options', 'idFormula', 'idOption')
            ->withTimestamps();
    }
}
