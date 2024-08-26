<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulaOption extends Model
{
    use HasFactory;

    // Les attributs qui sont assignables en masse.
    protected $fillable = ['formula_id', 'option_id'];

    // Relation avec le modèle Formula
    public function formula()
    {
        return $this->belongsTo(Formula::class, 'formula_id', 'id');
    }

    // Relation avec le modèle FormulaCustomOption
    public function customOption()
    {
        return $this->belongsTo(FormulaCustomOption::class, 'option_id', 'id');
    }
}
