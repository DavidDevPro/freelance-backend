<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormulaCustomOption extends Model
{
    protected $table = 'formula_custom_options';

    public function description()
    {
        return $this->hasOneThrough(
            FormulaDescription::class,
            FormulaOption::class,
            'option_id', // Foreign key on formula_options table
            'id', // Foreign key on formula_descriptions table
            'id', // Local key on formula_custom_options table
            'description_id' // Local key on formula_options table
        );
    }
}
