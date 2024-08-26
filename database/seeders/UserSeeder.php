<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupère l'ID de la permission 'admin'
        $adminPermissionId = DB::table('user_permissions')->where('labelPermission', 'admin')->value('id');

        DB::table('users')->insert([
            'identifiant' => 'admin',
            'email' => 'contact@davidwebprojects.fr',
            'password' => Hash::make('admin'), // Utilise Hash pour hasher le mot de passe
            'urlPictureProfil' => 'defaut.jpg',
            'user_permission_id' => $adminPermissionId, // Lien vers la permission admin
            'isActive' => true, // L'utilisateur admin est actif
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
