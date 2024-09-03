<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulaDefault extends Model
{
    use HasFactory;

    // Les attributs qui sont assignables en masse.
    protected $fillable = ['default_element_id', 'formula_id', 'description_id']; // Ajout de 'description_id'

    // Relation avec le modèle Formula
    public function formula()
    {
        return $this->belongsTo(Formula::class, 'formula_id', 'id');
    }

    // Relation avec le modèle FormulaDefaultElement
    public function defaultElement()
    {
        return $this->belongsTo(FormulaDefaultElement::class, 'default_element_id', 'id');
    }

    // Relation avec le modèle FormulaDescription
    public function description()
    {
        return $this->belongsTo(FormulaDescription::class, 'description_id', 'id'); // Ajout de la relation avec FormulaDescription
    }
}
