<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id(); // Clé primaire standard
            $table->string('proposal_number')->unique();
            $table->boolean('is_amendment')->default(false);
            $table->foreignId('parent_proposal_id')->nullable()->constrained('proposals')->onDelete('set null');
            $table->text('description')->nullable();
            $table->text('supplementalInfo')->nullable();
            $table->foreignId('formula_id')->nullable()->constrained('formulas')->onDelete('set null');
            $table->decimal('amount', 10, 2);
            $table->date('issue_date');
            $table->date('expiry_date');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('status_id')->nullable()->constrained('statuses')->onDelete('set null');
            $table->boolean('archived')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        // Récupérer l'ID du statut En Attente pour les propositions
        $statusPendingId = DB::table('statuses')
            ->where('label_status', 'En Attente')
            ->where('entity_type', 'proposal')
            ->value('id');

        // Mettre à jour les propositions existantes pour définir status_id avec la valeur par défaut
        DB::table('proposals')->update(['status_id' => $statusPendingId]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
