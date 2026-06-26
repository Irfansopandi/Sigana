<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik', 16)->nullable()->unique()->after('phone');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('nik');
            $table->date('tanggal_lahir')->nullable()->after('jenis_kelamin');
            $table->text('alamat')->nullable()->after('tanggal_lahir');
            $table->json('keahlian')->nullable()->after('alamat');
            $table->text('pengalaman')->nullable()->after('keahlian');
            $table->string('foto_ktp')->nullable()->after('pengalaman');
            $table->enum('status', ['active', 'pending', 'inactive'])->default('active')->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nik',
                'jenis_kelamin',
                'tanggal_lahir',
                'alamat',
                'keahlian',
                'pengalaman',
                'foto_ktp',
                'status',
            ]);
        });
    }
};