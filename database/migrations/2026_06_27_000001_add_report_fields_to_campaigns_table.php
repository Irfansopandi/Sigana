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
        Schema::table('campaigns', function (Blueprint $table) {
            $table->foreignId('submitted_by')->nullable()->after('assigned_to')->constrained('users')->nullOnDelete();
            $table->string('report_status')->default('menunggu')->after('submitted_by');
            $table->string('documentation_1')->nullable()->after('report_status');
            $table->string('documentation_2')->nullable()->after('documentation_1');
            $table->string('documentation_3')->nullable()->after('documentation_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropConstrainedForeignId('submitted_by');
            $table->dropColumn(['report_status', 'documentation_1', 'documentation_2', 'documentation_3']);
        });
    }
};
