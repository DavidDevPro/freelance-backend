<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserPermission;
use Illuminate\Support\Facades\DB;

class UserPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'labelPermission' => 'admin',
                'descriptionPermission' => 'Full access to the system', // Description pour l'admin
                'isDefault' => false, // Pas la permission par défaut
                'active' => true, // Active
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'labelPermission' => 'utilisateur',
                'descriptionPermission' => 'Basic user access with limited features', // Description pour l'utilisateur
                'isDefault' => true, // Permission par défaut
                'active' => true, // Active
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($permissions as $permission) {
            UserPermission::updateOrCreate(
                ['labelPermission' => $permission['labelPermission']], // Critère pour éviter les doublons
                $permission
            );
        }
    }
}
