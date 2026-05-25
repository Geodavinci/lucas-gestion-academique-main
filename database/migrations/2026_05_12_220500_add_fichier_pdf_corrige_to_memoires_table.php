<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('memoires', function (Blueprint $table) {
            $table->string('fichier_pdf_corrige')->nullable()->after('fichier_pdf');
        });
    }

    public function down(): void
    {
        Schema::table('memoires', function (Blueprint $table) {
            $table->dropColumn('fichier_pdf_corrige');
        });
    }
};