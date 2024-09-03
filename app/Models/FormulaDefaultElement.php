<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormulaDefaultElement extends Model
{
    protected $table = 'formula_default_elements';

    public function description()
    {
        return $this->hasOneThrough(
            FormulaDescription::class,
            FormulaDefault::class,
            'default_element_id',  // Foreign key on formula_defaults table
            'id',  // Foreign key on formula_descriptions table
            'id',  // Local key on formula_default_elements table
            'description_id'  // Local key on formula_defaults table
        );
    }
}
