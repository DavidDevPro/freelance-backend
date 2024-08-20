<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('formula_defaults', function (Blueprint $table) {
            $table->integer('idFormulaDefault')->autoIncrement(); // Clé primaire auto-incrémentée
            $table->integer('idDefaultElement'); // Clé étrangère vers la table 'default_elements'
            $table->integer('idFormula'); // Clé étrangère vers la table 'formulas'
            $table->timestamps(); // Ajoute les colonnes created_at et updated_at

            // Définir les clés étrangères
            $table->foreign('idDefaultElement')->references('idDefaultElement')->on('default_elements')->onDelete('cascade');
            $table->foreign('idFormula')->references('idFormula')->on('formulas')->onDelete('cascade');
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
