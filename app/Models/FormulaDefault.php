<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulaDefault extends Model
{
    use HasFactory;
    // Le nom de la table associée à ce modèle
    protected $table = 'formula_defaults';
    // Les attributs qui sont assignables en masse.
    protected $fillable = [
        'idDefaultElement',
        'idFormula',
    ];
    // Désactive les timestamps si vous ne voulez pas qu'ils soient automatiquement gérés par Eloquent
    public $timestamps = true;
    /**
     * Les relations avec les autres modèles.
     */
    // Relation avec le modèle Formula
    public function formula()
    {
        return $this->belongsTo(Formula::class, 'idFormula', 'idFormula');
    }
    // Relation avec le modèle DefaultElement
    public function defaultElement()
    {
        return $this->belongsTo(DefaultElement::class, 'idDefaultElement', 'idDefaultElement');
    }
}
