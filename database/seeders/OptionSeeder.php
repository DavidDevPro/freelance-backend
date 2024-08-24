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

            ['idOption' => 16, 'name' => 'Ajout de pages supplémentaires', 'description' => '', 'price' => null, 'active' => true],
            ['idOption' => 17, 'name' => 'Référencement Local', 'description' => '', 'price' => null, 'active' => true],
            ['idOption' => 18, 'name' => 'Google My Business', 'description' => '', 'price' => null, 'active' => true],
            ['idOption' => 19, 'name' => 'Suivi Analytics', 'description' => '', 'price' => null, 'active' => true],
            ['idOption' => 20, 'name' => 'Révision des contenus', 'description' => 'tous les 6 mois.', 'price' => null, 'active' => true],
        ];

        foreach ($options as $option) {
            Option::create($option);
        }
    }
}
