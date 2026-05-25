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
        Schema::create('memoire_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('memoire_id')->constrained('memoires')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('action'); // submitted, reviewed, changes_requested, approved, rejected
            $table->enum('old_status', ['draft', 'submitted', 'in_review', 'changes_requested', 'approved', 'rejected'])->nullable();
            $table->enum('new_status', ['draft', 'submitted', 'in_review', 'changes_requested', 'approved', 'rejected'])->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('memoire_id');
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memoire_history');
    }
};
