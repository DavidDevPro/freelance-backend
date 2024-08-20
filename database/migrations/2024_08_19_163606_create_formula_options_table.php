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
        Schema::create('formula_options', function (Blueprint $table) {
            $table->integer('idFormulaOptions')->autoIncrement(); // Clé primaire auto-incrémentée
            $table->integer('idFormula'); // Clé étrangère vers la table 'formulas'
            $table->integer('idOption'); // Clé étrangère vers la table 'options'
            $table->timestamps(); // Ajoute les colonnes created_at et updated_at

            // Définir les clés étrangères
            $table->foreign('idFormula')->references('idFormula')->on('formulas')->onDelete('cascade');
            $table->foreign('idOption')->references('idOption')->on('options')->onDelete('cascade');
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
