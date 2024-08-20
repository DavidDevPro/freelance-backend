<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Formula;

class FormulaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $formulas = [
            [
                'idFormula' => 1,
                'name' => 'Essentiel',
                'description' => "L'option idéale pour les sites vitrines et les projets de petites envergures",
                'basePrice' => 800.00,
                'popular' => false,
                'active' => true,
            ],
            [
                'idFormula' => 2,
                'name' => 'Premium',
                'description' => 'Idéal pour les projets de taille moyenne cherchant un impact significatif',
                'basePrice' => 1500.00,
                'popular' => true,
                'active' => true,
            ],
            [
                'idFormula' => 3,
                'name' => 'Expert',
                'description' => 'Pour les projets ambitieux nécessitant une expertise technique approfondie',
                'basePrice' => 2000.00,
                'popular' => false,
                'active' => true,
            ],
        ];

        foreach ($formulas as $formula) {
            Formula::create($formula);
        }
    }
}
