<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulaDefaultElement extends Model
{
    use HasFactory;

    // Définir les champs remplissables
    protected $fillable = ['name', 'description'];

    // Relation avec Formula via la table pivot 'formula_defaults'
    public function formulas()
    {
        return $this->belongsToMany(Formula::class, 'formula_defaults', 'default_element_id', 'formula_id')
                    ->withTimestamps();
    }
}
