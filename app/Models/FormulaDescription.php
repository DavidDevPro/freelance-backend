<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulaDescription extends Model
{
    use HasFactory;

    // Définir le nom de la table explicitement (optionnel si le nom du modèle suit la convention de Laravel)
    protected $table = 'formula_descriptions';

    // Définir les champs remplissables pour permettre l'utilisation de la méthode create() ou update()
    protected $fillable = ['description_text'];

    // Relation avec FormulaDefaults
    public function formulaDefaults()
    {
        return $this->hasMany(FormulaDefault::class, 'description_id', 'id'); // Correction pour pointer vers FormulaDefault
    }

    // Relation avec FormulaOptions
    public function formulaOptions()
    {
        return $this->hasMany(FormulaOption::class, 'description_id', 'id'); // Ajout de la relation avec FormulaOption
    }
}
