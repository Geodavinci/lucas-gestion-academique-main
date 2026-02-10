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
        Schema::create('soutenances', function (Blueprint $table) {
            $table->id();
            $table->date('date_soutenance');
            $table->enum('statut', ['Valide', 'Ajourne']);
            $table->text('description')->nullable();
            $table->foreignId('student_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('directeur_memoire_id')->nullable()->constrained('teachers')->nullOnDelete();
            $table->foreignId('evaluateur_id')->nullable()->constrained('teachers')->nullOnDelete();
            $table->foreignId('president_jury_id')->nullable()->constrained('teachers')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soutenances');
    }
};
