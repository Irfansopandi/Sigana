<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->unsignedInteger('victims')->default(0)->after('description_long');
        });

        Schema::table('transparency_reports', function (Blueprint $table) {
            $table->unsignedInteger('beneficiaries')->default(0)->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn('victims');
        });

        Schema::table('transparency_reports', function (Blueprint $table) {
            $table->dropColumn('beneficiaries');
        });
    }
};