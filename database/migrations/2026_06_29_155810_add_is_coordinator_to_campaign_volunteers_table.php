<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('campaign_volunteers', function (Blueprint $table) {
            $table->boolean('is_coordinator')->default(false)->after('verifikasi');
        });
    }

    public function down(): void
    {
        Schema::table('campaign_volunteers', function (Blueprint $table) {
            $table->dropColumn('is_coordinator');
        });
    }
};