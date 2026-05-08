<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('operational_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('admins')->cascadeOnDelete();
            $table->string('cost_code')->unique();
            $table->enum('category', ['listrik', 'air', 'wifi', 'kebersihan', 'lain-lain']);
            $table->text('description')->nullable();
            $table->unsignedInteger('amount');
            $table->unsignedTinyInteger('period_month');
            $table->unsignedSmallInteger('period_year');
            $table->date('payment_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operational_costs');
    }
};
