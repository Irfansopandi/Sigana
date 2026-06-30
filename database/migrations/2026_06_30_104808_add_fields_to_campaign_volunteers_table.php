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
            $table->boolean('minat_koordinator')->default(false)->after('campaign_role_id');
            $table->json('keahlian')->nullable()->after('minat_koordinator');
            $table->string('tugas_lain')->nullable()->after('campaign_role_id');
            $table->string('dokumen_1')->nullable()->after('pengalaman');
            $table->string('dokumen_2')->nullable()->after('dokumen_1');
            $table->string('dokumen_3')->nullable()->after('dokumen_2');
        });
    }

    public function down(): void
    {
        Schema::table('campaign_volunteers', function (Blueprint $table) {
            $table->dropColumn([
                'is_coordinator',
                'minat_koordinator',
                'keahlian',
                'tugas_lain',
                'dokumen_1',
                'dokumen_2',
                'dokumen_3',
            ]);
        });
    }
};
