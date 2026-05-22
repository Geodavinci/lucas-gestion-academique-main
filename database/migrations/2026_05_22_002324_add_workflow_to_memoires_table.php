<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('memoires', function (Blueprint $table) {
            $table->enum('status', ['draft', 'submitted', 'in_review', 'changes_requested', 'approved', 'rejected'])
                ->default('draft')
                ->after('titre');
            $table->timestamp('submitted_at')->nullable()->after('status');
            $table->timestamp('reviewed_at')->nullable()->after('submitted_at');
            $table->foreignId('reviewer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('review_notes')->nullable();
            $table->integer('version')->default(1);
            $table->index('status');
            $table->index('submitted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('memoires', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['submitted_at']);
            $table->dropForeignIdFor('users');
            $table->dropColumn(['status', 'submitted_at', 'reviewed_at', 'reviewer_id', 'review_notes', 'version']);
        });
    }
};
