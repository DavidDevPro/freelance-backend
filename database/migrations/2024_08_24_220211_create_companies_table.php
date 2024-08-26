<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id(); // Utilisation de la clé primaire standard Laravel (id)
            $table->string('company_name'); // Nommage snake_case pour les colonnes
            $table->string('phone', 15)->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable(); // Nommage snake_case
            $table->string('city')->nullable();
            $table->string('siret')->nullable();
            $table->string('ape_code')->nullable(); // Nommage snake_case
            $table->string('iban')->nullable();
            $table->text('header_text')->nullable(); // Nommage snake_case
            $table->text('footer_text')->nullable(); // Nommage snake_case
            $table->foreignId('created_by')->nullable()->constrained('users'); // Utilisation de foreignId avec clé étrangère
            $table->timestamps(); // Ajoute automatiquement created_at et updated_at
            $table->foreignId('updated_by')->nullable()->constrained('users'); // Utilisation de foreignId avec clé étrangère
        });

        // Récupérer l'ID des permissions admin
        $adminPermissionId = DB::table('user_permissions')
            ->where('labelPermission', 'admin')
            ->value('id');

        // Récupérer l'ID de l'utilisateur associé aux permissions admin
        $adminUserId = DB::table('users')
            ->where('user_permission_id', $adminPermissionId)
            ->value('id');

        // Modifier la table pour définir la valeur par défaut de created_by
        Schema::table('companies', function (Blueprint $table) use ($adminUserId) {
            $table->foreignId('created_by')->default($adminUserId)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
