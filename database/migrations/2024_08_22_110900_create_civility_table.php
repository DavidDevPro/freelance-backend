<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('civility', function (Blueprint $table) {
            $table->integer('idCivility')->autoIncrement(); // Utilisation de integer avec auto-incrémentation
            $table->string('shortLabel')->unique();
            $table->string('longLabel')->unique();
            $table->timestamps(); // Utilisation des timestamps pour created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('civility');
    }
};
