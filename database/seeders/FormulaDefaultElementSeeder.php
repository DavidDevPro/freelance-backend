<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormulaDefaultElement;

class FormulaDefaultElementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultElements = [
            ['id' => 1, 'name' => 'Type Site web', 'value' => 'Vitrine'],
            ['id' => 2, 'name' => 'Type Site web', 'value' => 'Professionnel'],
            ['id' => 3, 'name' => 'Nombre de pages incluses', 'value' => '3'],
            ['id' => 4, 'name' => 'Nombre de pages incluses', 'value' => '5'],
            ['id' => 5, 'name' => 'Nombre de pages incluses', 'value' => '8'],
            ['id' => 6, 'name' => 'Page de contact', 'value' => 'Simple'],
            ['id' => 7, 'name' => 'Page de contact', 'value' => 'Professionnel'],
            ['id' => 8, 'name' => 'SEO', 'value' => 'Essentiel'],
            ['id' => 9, 'name' => 'SEO', 'value' => 'Premium'],
            ['id' => 10, 'name' => 'SEO', 'value' => 'Expert'],
            ['id' => 11, 'name' => 'Cycle(s) de révision', 'value' => '1'],
            ['id' => 12, 'name' => 'Cycle(s) de révision', 'value' => '2'],
            ['id' => 13, 'name' => 'Cycle(s) de révision', 'value' => 'illimité'],
            ['id' => 14, 'name' => 'Support par', 'value' => 'email'],
            ['id' => 15, 'name' => 'Support par', 'value' => 'téléphone'],
            ['id' => 16, 'name' => 'Accès administrateur pour gestion des contenus (ajout, modification, suppression)', 'value' => ''],
            ['id' => 17, 'name' => 'Intégration API', 'value' => ''],
            ['id' => 18, 'name' => 'Accès Clients pour gestion des devis, factures, etc.', 'value' => ''],
            ['id' => 19, 'name' => 'Intégration API avancée et performante', 'value' => ''],
        ];

        foreach ($defaultElements as $element) {
            FormulaDefaultElement::updateOrCreate(
                ['id' => $element['id']], // Critère pour éviter les doublons
                $element
            );
        }
    }
}
