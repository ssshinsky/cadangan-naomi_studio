<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booking_carts', function (Blueprint $table) {
            $table->boolean('is_invalidated_by_closure')->default(false)->after('dp_amount');
            $table->foreignId('invalidated_by_closure_id')
                  ->nullable()
                  ->constrained('studio_closures')
                  ->nullOnDelete()
                  ->after('is_invalidated_by_closure');
        });
    }

    public function down(): void
    {
        Schema::table('booking_carts', function (Blueprint $table) {
            $table->dropForeign(['invalidated_by_closure_id']);
            $table->dropColumn(['is_invalidated_by_closure', 'invalidated_by_closure_id']);
        });
    }
};
