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

            ['idFormulaOptions' => 1, 'idOption' => 16, 'idFormula' => 1],
            ['idFormulaOptions' => 2, 'idOption' => 16, 'idFormula' => 2],
            ['idFormulaOptions' => 3, 'idOption' => 16, 'idFormula' => 3],
            ['idFormulaOptions' => 4, 'idOption' => 17, 'idFormula' => 1],
            ['idFormulaOptions' => 5, 'idOption' => 17, 'idFormula' => 2],
            ['idFormulaOptions' => 6, 'idOption' => 18, 'idFormula' => 1],
            ['idFormulaOptions' => 7, 'idOption' => 18, 'idFormula' => 2],
            ['idFormulaOptions' => 8, 'idOption' => 19, 'idFormula' => 1],
            ['idFormulaOptions' => 9, 'idOption' => 19, 'idFormula' => 2],
            ['idFormulaOptions' => 10, 'idOption' => 20, 'idFormula' => 1],
        ];

        foreach ($formulaOptions as $formulaOption) {
            FormulaOption::create($formulaOption);
        }
    }
}
