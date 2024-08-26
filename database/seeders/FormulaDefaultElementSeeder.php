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
            ['id' => 1, 'name' => 'Site web', 'description' => 'Vitrine'],
            ['id' => 2, 'name' => 'Site web', 'description' => 'Professionnel'],
            ['id' => 3, 'name' => 'Nombre de pages incluses', 'description' => '3'],
            ['id' => 4, 'name' => 'Nombre de pages incluses', 'description' => '5'],
            ['id' => 5, 'name' => 'Nombre de pages incluses', 'description' => '8'],
            ['id' => 6, 'name' => 'Page de contact', 'description' => 'Simple'],
            ['id' => 7, 'name' => 'Page de contact', 'description' => 'Professionnel'],
            ['id' => 8, 'name' => 'SEO', 'description' => 'Essentiel'],
            ['id' => 9, 'name' => 'SEO', 'description' => 'Premium'],
            ['id' => 10, 'name' => 'SEO', 'description' => 'Expert'],
            ['id' => 11, 'name' => 'Cycle(s) de révision', 'description' => '1'],
            ['id' => 12, 'name' => 'Cycle(s) de révision', 'description' => '2'],
            ['id' => 13, 'name' => 'Cycle(s) de révision', 'description' => 'illimité'],
            ['id' => 14, 'name' => 'Support par', 'description' => 'email'],
            ['id' => 15, 'name' => 'Support par', 'description' => 'téléphone'],
            ['id' => 16, 'name' => 'Accès administrateur pour gestion des contenus (ajout, modification, suppression)', 'description' => ''],
            ['id' => 17, 'name' => 'Intégration API', 'description' => ''],
            ['id' => 18, 'name' => 'Accès Clients pour gestion des devis, factures, etc.', 'description' => ''],
            ['id' => 19, 'name' => 'Intégration API avancée et performante', 'description' => ''],
        ];

        foreach ($defaultElements as $element) {
            FormulaDefaultElement::updateOrCreate(
                ['id' => $element['id']], // Critère pour éviter les doublons
                $element
            );
        }
    }
}
