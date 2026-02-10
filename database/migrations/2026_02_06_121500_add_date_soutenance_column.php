<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('soutenances', function (Blueprint $table) {
            if (!Schema::hasColumn('soutenances', 'date_soutenance')) {
                $table->date('date_soutenance')->nullable();
            }
        });

        if (Schema::hasColumn('soutenances', 'date_presence')) {
            DB::statement("UPDATE soutenances SET date_soutenance = date_presence WHERE date_soutenance IS NULL");
        }
    }

    public function down(): void
    {
        Schema::table('soutenances', function (Blueprint $table) {
            if (Schema::hasColumn('soutenances', 'date_soutenance')) {
                $table->dropColumn('date_soutenance');
            }
        });
    }
};
