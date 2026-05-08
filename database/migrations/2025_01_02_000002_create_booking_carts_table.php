<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('studio_id')->constrained('studios')->cascadeOnDelete();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->decimal('duration_hours', 4, 1);
            $table->unsignedSmallInteger('participant_count')->default(1);
            $table->unsignedInteger('total_price');
            $table->unsignedInteger('dp_amount');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_carts');
    }
};
