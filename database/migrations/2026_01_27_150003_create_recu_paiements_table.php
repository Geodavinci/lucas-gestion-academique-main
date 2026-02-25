<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recu_paiements', function (Blueprint $table) {
            $table->id();
            $table->string('numero_recu')->unique();
            $table->decimal('montant', 10, 2);
            $table->date('date_paiement');
            $table->string('fichier_pdf')->nullable();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recu_paiements');
    }
};
