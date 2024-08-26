<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formula extends Model
{
    use HasFactory;

    // Définir les champs remplissables
    protected $fillable = ['name', 'description', 'base_price', 'popular', 'active'];

    // Relation avec FormulaDefaultElement via la table pivot 'formula_defaults'
    public function defaultElements()
    {
        return $this->belongsToMany(FormulaDefaultElement::class, 'formula_defaults', 'formula_id', 'default_element_id')
                    ->withTimestamps();
    }

    // Relation avec FormulaCustomOption via la table pivot 'formula_options'
    public function customOptions()
    {
        return $this->belongsToMany(FormulaCustomOption::class, 'formula_options', 'formula_id', 'option_id')
                    ->withTimestamps();
    }
}
