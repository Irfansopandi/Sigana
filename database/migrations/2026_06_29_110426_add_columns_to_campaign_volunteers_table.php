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
        Schema::table('campaign_volunteers', function (Blueprint $table) {
            $table->foreignId('campaign_role_id')->nullable()->after('user_id')->constrained()->onDelete('set null');
            $table->string('alasan')->nullable()->after('catatan');
            $table->text('pengalaman')->nullable()->after('alasan');
            $table->enum('verifikasi', ['menunggu', 'diterima', 'ditolak'])->default('menunggu')->after('status');
            $table->text('catatan_admin')->nullable()->after('verifikasi');
        });
    }

    public function down(): void
    {
        Schema::table('campaign_volunteers', function (Blueprint $table) {
            $table->dropForeign(['campaign_role_id']);
            $table->dropColumn(['campaign_role_id', 'alasan', 'pengalaman', 'verifikasi', 'catatan_admin']);
        });
    }
};
