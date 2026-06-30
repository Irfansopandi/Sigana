<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE campaign_volunteers MODIFY COLUMN status ENUM('menunggu', 'aktif', 'selesai', 'ditolak') NOT NULL DEFAULT 'menunggu'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE campaign_volunteers MODIFY COLUMN status ENUM('aktif', 'selesai') NOT NULL DEFAULT 'aktif'");
    }
};