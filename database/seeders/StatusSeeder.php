<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['label_status' => 'Prospect', 'entity_type' => 'customer'],
            ['label_status' => 'Client', 'entity_type' => 'customer'],
            ['label_status' => 'Ébauche', 'entity_type' => 'project'],
            ['label_status' => 'En Attente', 'entity_type' => 'project'],
            ['label_status' => 'En Cours', 'entity_type' => 'project'],
            ['label_status' => 'Prêt à Clôturer', 'entity_type' => 'project'],
            ['label_status' => 'Clôturé', 'entity_type' => 'project'],
            ['label_status' => 'En Attente', 'entity_type' => 'proposal'],
            ['label_status' => 'Accepté', 'entity_type' => 'proposal'],
            ['label_status' => 'Refusé', 'entity_type' => 'proposal'],
            ['label_status' => 'En Attente', 'entity_type' => 'task'],
            ['label_status' => 'En Cours', 'entity_type' => 'task'],
            ['label_status' => 'Complétée', 'entity_type' => 'task'],
            ['label_status' => 'En Attente', 'entity_type' => 'invoice'],
            ['label_status' => 'Non Payée', 'entity_type' => 'invoice'],
            ['label_status' => 'Partiellement Payée', 'entity_type' => 'invoice'],
            ['label_status' => 'Totalement Payée', 'entity_type' => 'invoice'],
            ['label_status' => 'En Attente', 'entity_type' => 'payment'],
            ['label_status' => 'Confirmé', 'entity_type' => 'payment'],
            ['label_status' => 'Rejeté', 'entity_type' => 'payment'],
        ];

        foreach ($statuses as $status) {
            Status::create($status);
        }
    }
}
