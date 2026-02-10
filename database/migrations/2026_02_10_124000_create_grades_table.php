<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->decimal('note', 5, 2);
            $table->string('session')->default('normal');
            $table->date('date_saisie')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'course_id', 'session']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
