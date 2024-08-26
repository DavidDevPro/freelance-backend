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
        Schema::create('civilities', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée standard Laravel
            $table->string('shortLabel')->unique(); // Libellé court unique
            $table->string('longLabel')->unique(); // Libellé long unique
            $table->timestamps(); // Utilisation des timestamps pour created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('civilities');
    }
};

