<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('companies')->insert([
            [
                'company_name' => 'DavidWebProjects',
                'phone' => '06 59 95 68 94',
                'email' => 'contact@davidwebprojects.fr',
                'address' => '3 place helene grail',
                'postal_code' => '26760',
                'city' => 'BEAUMONT LES VALENCE',
                'siret' => '80219689900024',
                'ape_code' => '6201Z',
                'iban' => 'FR76 3000 6000 0112 3456 7890 189',
                'header_text' => '{companyName} Tél : {phone} Email : {email}',
                'footer_text' => '{companyName} {address}, {postalCode} {city} SIRET : {siret} - Code APE : {apeCode}',
                'created_by' => 1, // ID de l'administrateur
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Vous pouvez ajouter d'autres enregistrements ici si nécessaire
        ]);
    }
}
