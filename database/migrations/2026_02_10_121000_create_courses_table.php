<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('filiere_id')->constrained()->onDelete('cascade');
            $table->string('nom');
            $table->string('code')->unique();
            $table->unsignedTinyInteger('coefficient')->default(1);
            $table->string('semestre')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
