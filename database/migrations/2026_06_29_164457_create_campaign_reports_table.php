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
            $table->foreignId('coordinator_report_id')->constrained()->cascadeOnDelete();
            $table->string('photo');
            $table->string('caption')->nullable();
            $table->tinyInteger('order')->default(1);
            $table->timestamps();
        });

        Schema::create('coordinator_report_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coordinator_report_id')->constrained()->cascadeOnDelete();
            $table->string('category');
            $table->text('description')->nullable();
            $table->bigInteger('amount');
            $table->timestamps();
        });

        Schema::create('coordinator_report_timelines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coordinator_report_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('coordinator_report_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coordinator_report_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('file');
            $table->string('code')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coordinator_report_documents');
        Schema::dropIfExists('coordinator_report_timelines');
        Schema::dropIfExists('coordinator_report_items');
        Schema::dropIfExists('coordinator_report_photos');
    }
};