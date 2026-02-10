<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Clean up leftover temp table from a failed SQLite table rebuild
        if (Schema::hasTable('__temp__soutenances')) {
            Schema::drop('__temp__soutenances');
        }

        if (!Schema::hasTable('soutenances') && Schema::hasTable('presences')) {
            Schema::rename('presences', 'soutenances');
        }

        if (Schema::hasTable('soutenances')) {
            // Normalize old statut values before changing the enum constraint
            \Illuminate\Support\Facades\DB::statement(
                "UPDATE soutenances SET statut = 'Valide' WHERE statut = 'Present'"
            );
            \Illuminate\Support\Facades\DB::statement(
                "UPDATE soutenances SET statut = 'Ajourne' WHERE statut = 'Absent'"
            );

            Schema::table('soutenances', function (Blueprint $table) {
                if (!Schema::hasColumn('soutenances', 'description')) {
                    $table->text('description')->nullable();
                }
                $table->enum('statut', ['Valide', 'Ajourne'])->change();
            });
        }
    }

    public function down(): void
    {
        Schema::table('soutenances', function (Blueprint $table) {
            if (Schema::hasColumn('soutenances', 'description')) {
                $table->dropColumn('description');
            }
            $table->enum('statut', ['Present', 'Absent'])->change();
        });
    }
};
