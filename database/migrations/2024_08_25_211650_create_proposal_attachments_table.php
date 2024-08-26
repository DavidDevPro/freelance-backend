<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('proposal_attachments', function (Blueprint $table) {
            $table->id(); // Clé primaire
            $table->foreignId('proposal_id')->constrained('proposals')->onDelete('cascade');
            $table->string('filename'); // Nom du fichier (e.g., logo.pdf)
            $table->string('path'); // Chemin d'accès au fichier stocké
            $table->timestamps(); // Ajoute les colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal_attachments');
    }
};
