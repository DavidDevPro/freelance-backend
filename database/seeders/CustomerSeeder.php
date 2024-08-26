<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer l'ID de l'utilisateur admin
        $adminUserId = DB::table('users')->where('identifiant', 'admin')->value('id');

        // Données à insérer
        $customers = [
            [                
                'customer_number' => 'CLT0001',
                'civility_id' => 1,
                'company_name' => 'ACME Inc.',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone' => '0123456789',
                'address' => '123 Main St',
                'postal_code' => '75001',
                'city' => 'Paris',
                'country' => 'France',
                'additional_info' => 'VIP customer',
                'status_id' => 1, // Remplacer par un ID valide dans votre table statuses
                'user_id' => $adminUserId, // Assigner l'utilisateur
                'created_by' => $adminUserId,
                'updated_by' => $adminUserId,
            ],
            [
                'customer_number' => 'CLT0002',
                'civility_id' => 2,
                'company_name' => 'XYZ Corp.',
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '0987654321',
                'address' => '456 Elm St',
                'postal_code' => '69001',
                'city' => 'Lyon',
                'country' => 'France',
                'additional_info' => 'Regular customer',
                'status_id' => 1, // Remplacer par un ID valide dans votre table statuses
                'user_id' => $adminUserId, // Assigner l'utilisateur
                'created_by' => $adminUserId,
                'updated_by' => $adminUserId,
            ],
        ];

        // Insérer les données dans la table customers
        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
