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
            if (!Schema::hasColumn('soutenances', 'directeur_memoire_id')) {
                $table->foreignId('directeur_memoire_id')->nullable()->constrained('teachers')->nullOnDelete();
            }
            if (!Schema::hasColumn('soutenances', 'evaluateur_id')) {
                $table->foreignId('evaluateur_id')->nullable()->constrained('teachers')->nullOnDelete();
            }
            if (!Schema::hasColumn('soutenances', 'president_jury_id')) {
                $table->foreignId('president_jury_id')->nullable()->constrained('teachers')->nullOnDelete();
            }
        });

        if (Schema::hasColumn('soutenances', 'directeur_memoire')) {
            DB::statement("UPDATE soutenances SET directeur_memoire_id = CAST(directeur_memoire AS INTEGER) WHERE directeur_memoire IS NOT NULL AND directeur_memoire != ''");
        }
        if (Schema::hasColumn('soutenances', 'evaluateur')) {
            DB::statement("UPDATE soutenances SET evaluateur_id = CAST(evaluateur AS INTEGER) WHERE evaluateur IS NOT NULL AND evaluateur != ''");
        }
        if (Schema::hasColumn('soutenances', 'president_jury')) {
            DB::statement("UPDATE soutenances SET president_jury_id = CAST(president_jury AS INTEGER) WHERE president_jury IS NOT NULL AND president_jury != ''");
        }

        Schema::table('soutenances', function (Blueprint $table) {
            if (Schema::hasColumn('soutenances', 'directeur_memoire')) {
                $table->dropColumn('directeur_memoire');
            }
            if (Schema::hasColumn('soutenances', 'evaluateur')) {
                $table->dropColumn('evaluateur');
            }
            if (Schema::hasColumn('soutenances', 'president_jury')) {
                $table->dropColumn('president_jury');
            }
        });
    }

    public function down(): void
    {
        Schema::table('soutenances', function (Blueprint $table) {
            if (!Schema::hasColumn('soutenances', 'directeur_memoire')) {
                $table->string('directeur_memoire')->nullable();
            }
            if (!Schema::hasColumn('soutenances', 'evaluateur')) {
                $table->string('evaluateur')->nullable();
            }
            if (!Schema::hasColumn('soutenances', 'president_jury')) {
                $table->string('president_jury')->nullable();
            }
        });

        if (Schema::hasColumn('soutenances', 'directeur_memoire_id')) {
            DB::statement("UPDATE soutenances SET directeur_memoire = CAST(directeur_memoire_id AS TEXT) WHERE directeur_memoire_id IS NOT NULL");
        }
        if (Schema::hasColumn('soutenances', 'evaluateur_id')) {
            DB::statement("UPDATE soutenances SET evaluateur = CAST(evaluateur_id AS TEXT) WHERE evaluateur_id IS NOT NULL");
        }
        if (Schema::hasColumn('soutenances', 'president_jury_id')) {
            DB::statement("UPDATE soutenances SET president_jury = CAST(president_jury_id AS TEXT) WHERE president_jury_id IS NOT NULL");
        }

        Schema::table('soutenances', function (Blueprint $table) {
            if (Schema::hasColumn('soutenances', 'directeur_memoire_id')) {
                $table->dropConstrainedForeignId('directeur_memoire_id');
            }
            if (Schema::hasColumn('soutenances', 'evaluateur_id')) {
                $table->dropConstrainedForeignId('evaluateur_id');
            }
            if (Schema::hasColumn('soutenances', 'president_jury_id')) {
                $table->dropConstrainedForeignId('president_jury_id');
            }
        });
    }
};
