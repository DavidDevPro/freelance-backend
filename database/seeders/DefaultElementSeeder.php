<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DefaultElement;

class DefaultElementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultElements = [
            ['idDefaultElement' => 1, 'name' => 'Site web', 'description' => 'Vitrine'],
            ['idDefaultElement' => 2, 'name' => 'Site web', 'description' => 'Professionnel'],
            ['idDefaultElement' => 3, 'name' => 'Nombre de pages incluses', 'description' => '3'],
            ['idDefaultElement' => 4, 'name' => 'Nombre de pages incluses', 'description' => '5'],
            ['idDefaultElement' => 5, 'name' => 'Nombre de pages incluses', 'description' => '8'],
            ['idDefaultElement' => 6, 'name' => 'Page de contact', 'description' => 'Simple'],
            ['idDefaultElement' => 7, 'name' => 'Page de contact', 'description' => 'Professionnel'],
            ['idDefaultElement' => 8, 'name' => 'SEO', 'description' => 'Essentiel'],
            ['idDefaultElement' => 9, 'name' => 'SEO', 'description' => 'Premium'],
            ['idDefaultElement' => 10, 'name' => 'SEO', 'description' => 'Expert'],
            ['idDefaultElement' => 11, 'name' => 'Cycle(s) de révision', 'description' => '1'],
            ['idDefaultElement' => 12, 'name' => 'Cycle(s) de révision', 'description' => '2'],
            ['idDefaultElement' => 13, 'name' => 'Cycle(s) de révision', 'description' => 'illimité'],
            ['idDefaultElement' => 14, 'name' => 'Support par', 'description' => 'email'],
            ['idDefaultElement' => 15, 'name' => 'Support par', 'description' => 'téléphone'],
            ['idDefaultElement' => 16, 'name' => 'Accès administrateur pour gestion des contenus (ajout, modification, suppression)', 'description' => ''],
            ['idDefaultElement' => 17, 'name' => 'Intégration API', 'description' => ''],
            ['idDefaultElement' => 18, 'name' => 'Accès Clients pour gestion des devis, factures, etc.', 'description' => ''],
            ['idDefaultElement' => 19, 'name' => 'Intégration API avancée et performante', 'description' => ''],
        ];

        foreach ($defaultElements as $element) {
            DefaultElement::create($element);
        }
    }
}
