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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('location');
            $table->string('category');
            $table->string('image');
            $table->string('status');
            $table->decimal('collected_raw', 15, 2)->default(0);
            $table->decimal('target_raw', 15, 2);
            $table->integer('days_left');
            $table->date('date_published');
            $table->text('description_short');
            $table->text('description_long');
            $table->timestamps();
        });

        Schema::create('campaign_needs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('campaigns')->onDelete('cascade');
            $table->string('name');
            $table->string('qty');
            $table->timestamps();
        });

        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('campaigns')->onDelete('cascade');
            $table->string('name');
            $table->decimal('amount', 15, 2);
            $table->text('message')->nullable();
            $table->timestamps();
        });

        Schema::create('transparency_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('campaigns')->onDelete('cascade');
            $table->string('status');
            $table->string('status_class');
            $table->string('status_icon');
            $table->decimal('used', 15, 2)->default(0);
            $table->date('date');
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('report_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('transparency_reports')->onDelete('cascade');
            $table->string('kategori');
            $table->decimal('nominal', 15, 2);
            $table->string('progress');
            $table->string('icon');
            $table->text('desc');
            $table->timestamps();
        });

        Schema::create('report_timelines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('transparency_reports')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('icon');
            $table->timestamps();
        });

        Schema::create('report_evidences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('transparency_reports')->onDelete('cascade');
            $table->string('url');
            $table->text('desc');
            $table->timestamps();
        });

        Schema::create('report_docs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('transparency_reports')->onDelete('cascade');
            $table->string('doc_id');
            $table->string('nama');
            $table->decimal('nominal', 15, 2);
            $table->string('file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_docs');
        Schema::dropIfExists('report_evidences');
        Schema::dropIfExists('report_timelines');
        Schema::dropIfExists('report_allocations');
        Schema::dropIfExists('transparency_reports');
        Schema::dropIfExists('donations');
        Schema::dropIfExists('campaign_needs');
        Schema::dropIfExists('campaigns');
    }
};
