<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormulaDefault;

class FormulaDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $formulaDefaults = [
            ['idFormulaDefault' => 1, 'idDefaultElement' => 1, 'idFormula' => 1],
            ['idFormulaDefault' => 2, 'idDefaultElement' => 2, 'idFormula' => 2],
            ['idFormulaDefault' => 3, 'idDefaultElement' => 2, 'idFormula' => 3],
            ['idFormulaDefault' => 4, 'idDefaultElement' => 3, 'idFormula' => 1],
            ['idFormulaDefault' => 5, 'idDefaultElement' => 4, 'idFormula' => 2],
            ['idFormulaDefault' => 6, 'idDefaultElement' => 5, 'idFormula' => 3],
            ['idFormulaDefault' => 7, 'idDefaultElement' => 6, 'idFormula' => 1],
            ['idFormulaDefault' => 8, 'idDefaultElement' => 7, 'idFormula' => 2],
            ['idFormulaDefault' => 9, 'idDefaultElement' => 7, 'idFormula' => 3],
            ['idFormulaDefault' => 10, 'idDefaultElement' => 8, 'idFormula' => 1],
            ['idFormulaDefault' => 11, 'idDefaultElement' => 9, 'idFormula' => 2],
            ['idFormulaDefault' => 12, 'idDefaultElement' => 10, 'idFormula' => 3],
            ['idFormulaDefault' => 13, 'idDefaultElement' => 11, 'idFormula' => 1],
            ['idFormulaDefault' => 14, 'idDefaultElement' => 12, 'idFormula' => 2],
            ['idFormulaDefault' => 15, 'idDefaultElement' => 13, 'idFormula' => 3],
            ['idFormulaDefault' => 16, 'idDefaultElement' => 14, 'idFormula' => 1],
            ['idFormulaDefault' => 17, 'idDefaultElement' => 14, 'idFormula' => 2],
            ['idFormulaDefault' => 18, 'idDefaultElement' => 14, 'idFormula' => 3],
            ['idFormulaDefault' => 19, 'idDefaultElement' => 15, 'idFormula' => 2],
            ['idFormulaDefault' => 20, 'idDefaultElement' => 15, 'idFormula' => 3],
            ['idFormulaDefault' => 21, 'idDefaultElement' => 16, 'idFormula' => 2],
            ['idFormulaDefault' => 22, 'idDefaultElement' => 17, 'idFormula' => 2],
            ['idFormulaDefault' => 23, 'idDefaultElement' => 18, 'idFormula' => 3],
            ['idFormulaDefault' => 24, 'idDefaultElement' => 19, 'idFormula' => 3],
        ];

        foreach ($formulaDefaults as $formulaDefault) {
            FormulaDefault::create($formulaDefault);
        }
    }
}
