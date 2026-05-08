<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('open_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('admins')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('instructor_name');
            $table->string('instructor_photo')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('price');
            $table->string('thumbnail')->nullable();
            $table->string('song_title')->nullable();
            $table->string('whatsapp_link');
            $table->enum('day_of_week', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            $table->time('time_start');
            $table->time('time_end');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('open_classes');
    }
};
