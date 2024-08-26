<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulaCustomOption extends Model
{
    use HasFactory;

    // Définir les champs remplissables
    protected $fillable = ['name', 'description', 'price', 'active'];

    // Relation avec Formula via la table pivot 'formula_options'
    public function formulas()
    {
        return $this->belongsToMany(Formula::class, 'formula_options', 'option_id', 'formula_id')
                    ->withTimestamps();
    }
}
