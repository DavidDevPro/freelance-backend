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
                'id' => 1,
                'name' => 'Essentiel',
                'description' => "L'option idéale pour les sites vitrines et les projets de petites envergures",
                'base_price' => 800.00, // Assurez-vous que cela correspond à la colonne dans la migration
                'popular' => false,
                'active' => true,
            ],
            [
                'id' => 2,
                'name' => 'Premium',
                'description' => 'Idéal pour les projets de taille moyenne cherchant un impact significatif',
                'base_price' => 1500.00,
                'popular' => true,
                'active' => true,
            ],
            [
                'id' => 3,
                'name' => 'Expert',
                'description' => 'Pour les projets ambitieux nécessitant une expertise technique approfondie',
                'base_price' => 2000.00,
                'popular' => false,
                'active' => true,
            ],
            [
                'id' => 4,
                'name' => 'Prendre un rendez-vous',
                'description' => '',
                'base_price' => 0.00,
                'popular' => false,
                'active' => true,
            ],
        ];

        foreach ($formulas as $formula) {
            Formula::updateOrCreate(
                ['id' => $formula['id']], // Critère pour éviter les doublons
                $formula
            );
        }
    }
}
