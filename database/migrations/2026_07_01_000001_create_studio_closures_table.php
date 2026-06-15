<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('studio_closures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('studio_id')->constrained('studios')->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('admins')->cascadeOnDelete();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('reason', 255);
            $table->timestamps();

            // Composite index untuk mempercepat query overlap berdasarkan studio dan tanggal
            $table->index(['studio_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('studio_closures');
    }
};
