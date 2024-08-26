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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Clé primaire standardisée de type bigIncrements
            $table->string('identifiant')->unique(); // Nom d'utilisateur unique
            $table->string('email')->unique(); // Email unique
            $table->timestamp('email_verified_at')->nullable(); // Date de vérification de l'email
            $table->string('password');
            $table->string('urlPictureProfil')->default('defaut.jpg'); // Photo de profil par défaut
            $table->foreignId('user_permission_id')->nullable()->constrained('user_permissions'); // Clé étrangère compatible avec bigIncrements
            $table->boolean('isActive')->default(true); // Compte actif par défaut
            $table->rememberToken(); // Jeton de connexion pour "Remember Me"
            $table->timestamps(); // Champs created_at et updated_at gérés automatiquement par Laravel
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
