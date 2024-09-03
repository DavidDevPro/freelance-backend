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
            $table->id(); 
            $table->foreignId('formula_id')->constrained('formulas')->onDelete('cascade'); 
            $table->foreignId('option_id')->constrained('formula_custom_options')->onDelete('cascade'); 
            $table->foreignId('description_id')->nullable()->constrained('formula_descriptions')->onDelete('cascade'); // Ajout de la clé étrangère vers 'formula_descriptions'
            $table->timestamps(); 
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
