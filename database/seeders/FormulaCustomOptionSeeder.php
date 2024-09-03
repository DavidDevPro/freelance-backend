<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormulaCustomOption;

class FormulaCustomOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $options = [
            ['id' => 1, 'name' => 'Ajout de pages supplémentaires', 'value' => '', 'price' => null],
            ['id' => 2, 'name' => 'Référencement Local', 'value' => '', 'price' => null],
            ['id' => 3, 'name' => 'Google My Business', 'value' => '', 'price' => null],
            ['id' => 4, 'name' => 'Suivi Analytics', 'value' => '', 'price' => null],
            ['id' => 5, 'name' => 'Révision des contenus', 'value' => 'tous les 6 mois.', 'price' => null],
        ];

        foreach ($options as $option) {
            FormulaCustomOption::updateOrCreate(
                ['id' => $option['id']], // Critère pour éviter les doublons
                $option
            );
        }
    }
}
