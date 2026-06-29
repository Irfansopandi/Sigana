<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coordinator_report_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coordinator_report_id')
                  ->constrained('coordinator_reports')
                  ->onDelete('cascade');
            $table->string('photo_path');
            $table->string('caption')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coordinator_report_photos');
    }
};