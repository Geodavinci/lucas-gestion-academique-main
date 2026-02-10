<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('soutenances')) {
            // Backfill date_presence from date_soutenance if needed
            if (Schema::hasColumn('soutenances', 'date_presence') && Schema::hasColumn('soutenances', 'date_soutenance')) {
                DB::statement("UPDATE soutenances SET date_presence = date_soutenance WHERE date_presence IS NULL");
            }

            // Make date_presence nullable to unblock inserts
            Schema::table('soutenances', function (Blueprint $table) {
                if (Schema::hasColumn('soutenances', 'date_presence')) {
                    $table->date('date_presence')->nullable()->change();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('soutenances')) {
            Schema::table('soutenances', function (Blueprint $table) {
                if (Schema::hasColumn('soutenances', 'date_presence')) {
                    $table->date('date_presence')->nullable(false)->change();
                }
            });
        }
    }
};
