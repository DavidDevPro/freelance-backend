<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormulaDefault;
use App\Models\FormulaDescription;

class FormulaDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vérifiez que les IDs de description existent dans la table 'formula_descriptions'
        $existingDescriptionIds = FormulaDescription::pluck('id')->toArray();

        // Utilisez la première description disponible si aucune description par défaut n'existe
        $defaultDescriptionId = $existingDescriptionIds[0] ?? null; // Utiliser l'ID de description disponible, ou null si aucun n'existe

        // Si aucune description n'existe, retourner une erreur
        if (!$defaultDescriptionId) {
            throw new \Exception('Aucune description disponible pour peupler formula_defaults.');
        }

        $formulaDefaults = [
            ['id' => 1, 'default_element_id' => 1, 'formula_id' => 1, 'description_id' =>1],
            ['id' => 2, 'default_element_id' => 2, 'formula_id' => 2, 'description_id' =>7],
            ['id' => 3, 'default_element_id' => 2, 'formula_id' => 3, 'description_id' =>15],
            ['id' => 4, 'default_element_id' => 3, 'formula_id' => 1, 'description_id' =>2],
            ['id' => 5, 'default_element_id' => 4, 'formula_id' => 2, 'description_id' =>8],
            ['id' => 6, 'default_element_id' => 5, 'formula_id' => 3, 'description_id' =>16],
            ['id' => 7, 'default_element_id' => 6, 'formula_id' => 1, 'description_id' =>3],
            ['id' => 8, 'default_element_id' => 7, 'formula_id' => 2, 'description_id' =>9],
            ['id' => 9, 'default_element_id' => 7, 'formula_id' => 3, 'description_id' =>17],
            ['id' => 10, 'default_element_id' => 8, 'formula_id' => 1, 'description_id' =>4],
            ['id' => 11, 'default_element_id' => 9, 'formula_id' => 2, 'description_id' =>10],
            ['id' => 12, 'default_element_id' => 10, 'formula_id' => 3, 'description_id' =>18],
            ['id' => 13, 'default_element_id' => 11, 'formula_id' => 1, 'description_id' =>5],
            ['id' => 14, 'default_element_id' => 12, 'formula_id' => 2, 'description_id' =>11],
            ['id' => 15, 'default_element_id' => 13, 'formula_id' => 3, 'description_id' =>19],
            ['id' => 16, 'default_element_id' => 14, 'formula_id' => 1, 'description_id' =>6],
            ['id' => 17, 'default_element_id' => 14, 'formula_id' => 2, 'description_id' =>12],
            ['id' => 18, 'default_element_id' => 14, 'formula_id' => 3, 'description_id' =>20],
            ['id' => 19, 'default_element_id' => 15, 'formula_id' => 2, 'description_id' =>12],
            ['id' => 20, 'default_element_id' => 15, 'formula_id' => 3, 'description_id' =>20],
            ['id' => 21, 'default_element_id' => 16, 'formula_id' => 2, 'description_id' =>13],
            ['id' => 22, 'default_element_id' => 16, 'formula_id' => 3, 'description_id' =>13],
            ['id' => 23, 'default_element_id' => 17, 'formula_id' => 3, 'description_id' =>21],
            ['id' => 24, 'default_element_id' => 18, 'formula_id' => 2, 'description_id' =>14],
            ['id' => 25, 'default_element_id' => 19, 'formula_id' => 3, 'description_id' =>22],
        ];

        foreach ($formulaDefaults as $formulaDefault) {
            FormulaDefault::updateOrCreate(
                ['id' => $formulaDefault['id']], // Critère pour éviter les doublons
                $formulaDefault
            );
        }
    }
}