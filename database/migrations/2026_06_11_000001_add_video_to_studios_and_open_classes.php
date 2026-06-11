<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('studios', function (Blueprint $table) {
            $table->string('video')->nullable()->after('floor_type');
        });

        Schema::table('open_classes', function (Blueprint $table) {
            $table->string('video')->nullable()->after('thumbnail');
        });
    }

    public function down(): void
    {
        Schema::table('studios', function (Blueprint $table) {
            $table->dropColumn('video');
        });

        Schema::table('open_classes', function (Blueprint $table) {
            $table->dropColumn('video');
        });
    }
};
