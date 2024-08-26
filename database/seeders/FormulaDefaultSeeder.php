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
            ['id' => 1, 'default_element_id' => 1, 'formula_id' => 1],
            ['id' => 2, 'default_element_id' => 2, 'formula_id' => 2],
            ['id' => 3, 'default_element_id' => 2, 'formula_id' => 3],
            ['id' => 4, 'default_element_id' => 3, 'formula_id' => 1],
            ['id' => 5, 'default_element_id' => 4, 'formula_id' => 2],
            ['id' => 6, 'default_element_id' => 5, 'formula_id' => 3],
            ['id' => 7, 'default_element_id' => 6, 'formula_id' => 1],
            ['id' => 8, 'default_element_id' => 7, 'formula_id' => 2],
            ['id' => 9, 'default_element_id' => 7, 'formula_id' => 3],
            ['id' => 10, 'default_element_id' => 8, 'formula_id' => 1],
            ['id' => 11, 'default_element_id' => 9, 'formula_id' => 2],
            ['id' => 12, 'default_element_id' => 10, 'formula_id' => 3],
            ['id' => 13, 'default_element_id' => 11, 'formula_id' => 1],
            ['id' => 14, 'default_element_id' => 12, 'formula_id' => 2],
            ['id' => 15, 'default_element_id' => 13, 'formula_id' => 3],
            ['id' => 16, 'default_element_id' => 14, 'formula_id' => 1],
            ['id' => 17, 'default_element_id' => 14, 'formula_id' => 2],
            ['id' => 18, 'default_element_id' => 14, 'formula_id' => 3],
            ['id' => 19, 'default_element_id' => 15, 'formula_id' => 2],
            ['id' => 20, 'default_element_id' => 15, 'formula_id' => 3],
            ['id' => 21, 'default_element_id' => 16, 'formula_id' => 2],
            ['id' => 22, 'default_element_id' => 17, 'formula_id' => 2],
            ['id' => 23, 'default_element_id' => 18, 'formula_id' => 3],
            ['id' => 24, 'default_element_id' => 19, 'formula_id' => 3],
        ];

        foreach ($formulaDefaults as $formulaDefault) {
            FormulaDefault::updateOrCreate(
                ['id' => $formulaDefault['id']], // Critère pour éviter les doublons
                $formulaDefault
            );
        }
    }
}
