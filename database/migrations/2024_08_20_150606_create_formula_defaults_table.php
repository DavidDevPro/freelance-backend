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
        Schema::create('formula_defaults', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée standard Laravel
            $table->foreignId('default_element_id')->constrained('formula_default_elements')->onDelete('cascade'); // Clé étrangère vers 'formula_default_elements'
            $table->foreignId('formula_id')->constrained('formulas')->onDelete('cascade'); // Clé étrangère vers 'formulas'
            $table->timestamps(); // Ajoute les colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formula_defaults');
    }
};
