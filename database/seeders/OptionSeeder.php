<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Option;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $options = [
            ['idOption' => 1, 'name' => 'Site web', 'description' => 'Vitrine', 'price' => null, 'active' => true],
            ['idOption' => 2, 'name' => 'Site web', 'description' => 'Professionnel', 'price' => null, 'active' => true],
            ['idOption' => 3, 'name' => 'Nombre de pages incluses', 'description' => '3', 'price' => null, 'active' => true],
            ['idOption' => 4, 'name' => 'Nombre de pages incluses', 'description' => '5', 'price' => null, 'active' => true],
            ['idOption' => 5, 'name' => 'Nombre de pages incluses', 'description' => '8', 'price' => null, 'active' => true],
            ['idOption' => 6, 'name' => 'Page de contact', 'description' => 'Simple', 'price' => null, 'active' => true],
            ['idOption' => 7, 'name' => 'Page de contact', 'description' => 'Professionnel', 'price' => null, 'active' => true],
            ['idOption' => 8, 'name' => 'SEO', 'description' => 'Essentiel', 'price' => null, 'active' => true],
            ['idOption' => 9, 'name' => 'SEO', 'description' => 'Premium', 'price' => null, 'active' => true],
            ['idOption' => 10, 'name' => 'SEO', 'description' => 'Expert', 'price' => null, 'active' => true],
            ['idOption' => 11, 'name' => 'Cycle(s) de révision', 'description' => '1', 'price' => null, 'active' => true],
            ['idOption' => 12, 'name' => 'Cycle(s) de révision', 'description' => '2', 'price' => null, 'active' => true],
            ['idOption' => 13, 'name' => 'Cycle(s) de révision', 'description' => 'illimité', 'price' => null, 'active' => true],
            ['idOption' => 14, 'name' => 'Support par', 'description' => 'email', 'price' => null, 'active' => true],
            ['idOption' => 15, 'name' => 'Support par', 'description' => 'téléphone', 'price' => null, 'active' => true],
            ['idOption' => 16, 'name' => 'Ajout de pages supplémentaires', 'description' => '', 'price' => null, 'active' => true],
            ['idOption' => 17, 'name' => 'Référencement Local', 'description' => '', 'price' => null, 'active' => true],
            ['idOption' => 18, 'name' => 'Google My Business', 'description' => '', 'price' => null, 'active' => true],
            ['idOption' => 19, 'name' => 'Suivi Analytics', 'description' => '', 'price' => null, 'active' => true],
            ['idOption' => 20, 'name' => 'Révision des contenus (horaires, tarifs, etc.)', 'description' => 'tous les 6 mois.', 'price' => null, 'active' => true],
        ];

        foreach ($options as $option) {
            Option::create($option);
        }
    }
}
