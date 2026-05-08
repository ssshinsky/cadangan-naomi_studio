<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Tambah end_date untuk multi-hari
            $table->date('end_date')->nullable()->after('date');
            // Ubah duration_hours ke decimal untuk support 0.5 jam
            $table->decimal('duration_hours', 4, 1)->change();
            // Tambah jumlah hari
            $table->unsignedSmallInteger('total_days')->default(1)->after('duration_hours');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['end_date', 'total_days']);
        });
    }
};
