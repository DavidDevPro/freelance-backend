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
        Schema::create('default_elements', function (Blueprint $table) {
            $table->integer('idDefaultElement')->autoIncrement(); // Clé primaire auto-incrémentée
            $table->string('name'); // Nom de l'élément par défaut
            $table->text('description')->nullable(); // Description de l'élément par défaut
            $table->timestamps(); // Ajoute les colonnes created_at et updated_at
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('default_elements');
    }
};
