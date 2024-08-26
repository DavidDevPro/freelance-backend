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
        Schema::create('customers', function (Blueprint $table) {
            $table->id(); // Utilisation de la clé primaire standard Laravel
            $table->string('customer_number')->index(); // Numéro client avec index
            $table->foreignId('civility_id')
                  ->nullable()
                  ->constrained('civilities')
                  ->onDelete('set null')
                  ->onUpdate('cascade')
                  ->index()
                  ->name('fk_customers_civility_id'); // Nom unique pour la contrainte
            $table->string('company_name')->nullable(); // Nom de l'entreprise
            $table->string('last_name')->nullable(); // Nom de famille du client
            $table->string('first_name')->nullable(); // Prénom du client
            $table->string('phone', 15)->nullable(); // Téléphone du client
            $table->string('email')->nullable(); // Email du client
            $table->string('address')->nullable(); // Adresse du client
            $table->string('postal_code')->nullable(); // Code postal du client
            $table->string('city'); // Ville du client (non nullable)
            $table->string('country')->nullable(); // Pays du client
            $table->text('additional_info')->nullable(); // Informations supplémentaires
            $table->foreignId('status_id')
                  ->nullable()
                  ->constrained('statuses')
                  ->onDelete('set null')
                  ->onUpdate('cascade')
                  ->index()
                  ->name('fk_customers_status_id'); // Nom unique pour la contrainte
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null')
                  ->onUpdate('cascade')
                  ->index()
                  ->name('fk_customers_user_id'); // Nom unique pour la contrainte
            $table->foreignId('created_by')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null')
                  ->onUpdate('cascade')
                  ->index()
                  ->name('fk_customers_created_by'); // Nom unique pour la contrainte
            $table->timestamps(); // Ajoute automatiquement created_at et updated_at
            $table->foreignId('updated_by')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null')
                  ->onUpdate('cascade')
                  ->index()
                  ->name('fk_customers_updated_by'); // Nom unique pour la contrainte
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
