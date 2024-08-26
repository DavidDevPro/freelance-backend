<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestimonialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id(); // Utilisation de l'ID auto-incrémenté standard Laravel
            $table->string('image_url')->nullable(); // Permettre que l'URL de l'image soit nullable
            $table->string('name');
            $table->string('role');
            $table->text('comment');
            $table->decimal('rating', 2, 1); // Note sur 2 chiffres avant la virgule et 1 après
            $table->string('source')->nullable(); // Ajouter la colonne source
            $table->timestamps(); // Colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('testimonials');
    }
}
