<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Civility;

class CivilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $civilities = [
            [
                'shortLabel' => 'Mr',
                'longLabel' => 'Monsieur',
            ],
            [
                'shortLabel' => 'Mme',
                'longLabel' => 'Madame',
            ],
            // Ajoutez d'autres civilités ici si nécessaire
        ];

        foreach ($civilities as $civility) {
            Civility::create($civility);
        }
    }
}
