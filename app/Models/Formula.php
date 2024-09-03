<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formula extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'base_price', 'popular', 'active'];

    public function defaultElements()
    {
        return $this->belongsToMany(FormulaDefaultElement::class, 'formula_defaults', 'formula_id', 'default_element_id')
                    ->withPivot('description_id') // Charger 'description_id' depuis la table pivot
                    ->with(['description']) // Assure-toi que la relation 'description' est correctement chargée
                    ->withTimestamps();
    }

    public function customOptions()
    {
        return $this->belongsToMany(FormulaCustomOption::class, 'formula_options', 'formula_id', 'option_id')
                    ->withPivot('description_id') // Charger 'description_id' depuis la table pivot
                    ->with(['description']) // Assure-toi que la relation 'description' est correctement chargée
                    ->withTimestamps();
    }
}
