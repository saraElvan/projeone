<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            
            // Kullanıcı Sahipliği (Kullanıcı silinirse görevleri de silinir)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Temel Bilgiler
            $table->string('title', 160);
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'done'])->default('pending');

            // Metadata Detayları
            $table->date('due_date')->nullable();
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->string('notes', 500)->nullable();

            $table->timestamps();

            // Hızlı Arama İndeksleri
            $table->index(['status', 'title']);
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};