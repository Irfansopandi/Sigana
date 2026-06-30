<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('coordinator_reports')) {
            Schema::create('coordinator_reports', function (Blueprint $table) {
                $table->id();
                $table->foreignId('campaign_id')->constrained('campaigns')->onDelete('cascade');
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('title');
                $table->text('description')->nullable();
                $table->integer('victim_helped')->default(0);
                $table->decimal('total_distribution', 15, 2)->default(0);
                $table->date('reported_at')->nullable();
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                $table->text('rejection_note')->nullable();
                $table->datetime('verified_at')->nullable();
                $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
                $table->timestamps();
            });
        } else {
            // Alter the column to match 'approved' instead of 'verified'
            try {
                DB::statement("ALTER TABLE coordinator_reports MODIFY COLUMN status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending'");
            } catch (\Exception $e) {
                // Fallback for sqlite if needed, but project uses mysql
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('coordinator_reports');
    }
};
