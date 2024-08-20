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
            $table->integer('id')->autoIncrement();
            $table->string('image_url')->nullable(); // Permettre que l'URL de l'image soit nullable
            $table->string('name');
            $table->string('role');
            $table->text('description');
            $table->decimal('rating', 2, 1);
            $table->string('source')->nullable(); // Ajouter la colonne source
            $table->timestamps();
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
