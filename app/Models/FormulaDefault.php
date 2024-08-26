<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulaDefault extends Model
{
    use HasFactory;

    // Les attributs qui sont assignables en masse.
    protected $fillable = ['default_element_id', 'formula_id'];

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
}
