<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormulaOption;

class FormulaOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $formulaOptions = [

            ['idFormulaOptions' => 1, 'idOption' => 1, 'idFormula' => 1],
            ['idFormulaOptions' => 2, 'idOption' => 1, 'idFormula' => 2],
            ['idFormulaOptions' => 3, 'idOption' => 1, 'idFormula' => 3],
            ['idFormulaOptions' => 4, 'idOption' => 2, 'idFormula' => 1],
            ['idFormulaOptions' => 5, 'idOption' => 2, 'idFormula' => 2],
            ['idFormulaOptions' => 6, 'idOption' => 3, 'idFormula' => 1],
            ['idFormulaOptions' => 7, 'idOption' => 3, 'idFormula' => 2],
            ['idFormulaOptions' => 8, 'idOption' => 4, 'idFormula' => 1],
            ['idFormulaOptions' => 9, 'idOption' => 4, 'idFormula' => 2],
            ['idFormulaOptions' => 10, 'idOption' => 5, 'idFormula' => 1],
        ];

        foreach ($formulaOptions as $formulaOption) {
            FormulaOption::create($formulaOption);
        }
    }
}
