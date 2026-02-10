<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('presences') && !Schema::hasTable('soutenances')) {
            Schema::rename('presences', 'soutenances');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('soutenances') && !Schema::hasTable('presences')) {
            Schema::rename('soutenances', 'presences');
        }
    }
};
