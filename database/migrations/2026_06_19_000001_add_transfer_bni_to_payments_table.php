<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE payments MODIFY payment_method ENUM('transfer_bca', 'transfer_mandiri', 'transfer_bni', 'qris', 'cash') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE payments MODIFY payment_method ENUM('transfer_bca', 'transfer_mandiri', 'qris', 'cash') NOT NULL");
    }
};
