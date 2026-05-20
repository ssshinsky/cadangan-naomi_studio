<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('open_classes', function (Blueprint $table) {
            if (!Schema::hasColumn('open_classes', 'early_bird_price')) {
                $table->unsignedInteger('early_bird_price')->default(0)->after('price');
            }
            if (!Schema::hasColumn('open_classes', 'class_date')) {
                $table->date('class_date')->nullable()->after('early_bird_price');
            }
        });
    }

    public function down(): void
    {
        Schema::table('open_classes', function (Blueprint $table) {
            if (Schema::hasColumn('open_classes', 'class_date')) {
                $table->dropColumn('class_date');
            }
            if (Schema::hasColumn('open_classes', 'early_bird_price')) {
                $table->dropColumn('early_bird_price');
            }
        });
    }
};
