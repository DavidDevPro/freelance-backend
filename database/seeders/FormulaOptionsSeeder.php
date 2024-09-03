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
            ['id' => 1, 'option_id' => 1, 'formula_id' => 1, 'description_id' =>23],
            ['id' => 2, 'option_id' => 1, 'formula_id' => 2, 'description_id' =>23],
            ['id' => 3, 'option_id' => 1, 'formula_id' => 3, 'description_id' =>23],
            ['id' => 4, 'option_id' => 2, 'formula_id' => 1, 'description_id' =>24],
            ['id' => 5, 'option_id' => 2, 'formula_id' => 2, 'description_id' =>24],
            ['id' => 6, 'option_id' => 3, 'formula_id' => 1, 'description_id' =>25],
            ['id' => 7, 'option_id' => 3, 'formula_id' => 2, 'description_id' =>25],
            ['id' => 8, 'option_id' => 4, 'formula_id' => 1, 'description_id' =>26],
            ['id' => 9, 'option_id' => 4, 'formula_id' => 2, 'description_id' =>26],
            ['id' => 10, 'option_id' => 5, 'formula_id' => 1, 'description_id' =>27],
        ];

        foreach ($formulaOptions as $formulaOption) {
            FormulaOption::updateOrCreate(
                ['id' => $formulaOption['id']], // Critère pour éviter les doublons
                $formulaOption
            );
        }
    }
}
