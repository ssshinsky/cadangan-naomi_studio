<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('mentors')) {
            Schema::table('mentors', function (Blueprint $table) {
                if (!Schema::hasColumn('mentors', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('photo');
                }
            });
        }

        if (Schema::hasTable('studios')) {
            Schema::table('studios', function (Blueprint $table) {
                if (!Schema::hasColumn('studios', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('is_available');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('mentors')) {
            Schema::table('mentors', function (Blueprint $table) {
                if (Schema::hasColumn('mentors', 'is_active')) {
                    $table->dropColumn('is_active');
                }
            });
        }

        if (Schema::hasTable('studios')) {
            Schema::table('studios', function (Blueprint $table) {
                if (Schema::hasColumn('studios', 'is_active')) {
                    $table->dropColumn('is_active');
                }
            });
        }
    }
};
