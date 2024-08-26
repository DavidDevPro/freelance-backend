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
        Schema::create('formula_options', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée standard Laravel
            $table->foreignId('formula_id')->constrained('formulas')->onDelete('cascade'); // Clé étrangère vers la table 'formulas'
            $table->foreignId('option_id')->constrained('formula_custom_options')->onDelete('cascade'); // Clé étrangère vers la table 'formula_custom_options'
            $table->timestamps(); // Ajoute les colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formula_options');
    }
};
