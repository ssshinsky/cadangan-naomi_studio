<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menggunakan pola Laravel built-in database notifications:
     * - Primary key: uuid (bukan auto-increment bigint)
     * - notifiable_type + notifiable_id: morphs untuk target notifikasi (Admin model)
     * - data: json berisi payload notifikasi (booking_id, booking_code, customer_name)
     * - read_at: null = belum dibaca, terisi = sudah dibaca
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->string('notifiable_type');
            $table->unsignedBigInteger('notifiable_id');
            $table->json('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['notifiable_type', 'notifiable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
