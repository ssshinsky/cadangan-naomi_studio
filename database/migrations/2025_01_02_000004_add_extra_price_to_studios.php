<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('studios', function (Blueprint $table) {
            $table->unsignedInteger('extra_price_per_hour')->default(0)->after('price_per_hour');
            $table->unsignedSmallInteger('extra_price_threshold')->default(0)->after('extra_price_per_hour');
            // extra_price_threshold = batas orang sebelum kena tarif extra
        });
    }

    public function down(): void
    {
        Schema::table('studios', function (Blueprint $table) {
            $table->dropColumn(['extra_price_per_hour', 'extra_price_threshold']);
        });
    }
};
