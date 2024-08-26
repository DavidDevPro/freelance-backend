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
        Schema::create('proposal_custom_options', function (Blueprint $table) {
            $table->id(); // Clé primaire
            $table->foreignId('proposal_id')->constrained('proposals')->onDelete('cascade');
            $table->string('name'); // Nom de l'option
            $table->text('description')->nullable(); // Description de l'option
            $table->decimal('price', 10, 2)->nullable(); // Prix de l'option
            $table->timestamps(); // Ajoute les colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal_custom_options');
    }
};
