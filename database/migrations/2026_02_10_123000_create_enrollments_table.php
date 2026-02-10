<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('filiere_id')->constrained()->onDelete('cascade');
            $table->string('annee_academique');
            $table->timestamps();

            $table->unique(['student_id', 'filiere_id', 'annee_academique']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
