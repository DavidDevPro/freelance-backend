<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulaOption extends Model
{
    use HasFactory;

    // Définir la table associée
    protected $table = 'formula_options';

    // Définir les champs remplissables
    protected $fillable = ['idFormula', 'idOption'];
}
