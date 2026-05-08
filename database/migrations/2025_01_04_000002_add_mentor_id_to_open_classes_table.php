<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('open_classes', function (Blueprint $table) {
            $table->foreignId('mentor_id')->nullable()->constrained('mentors')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('open_classes', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Mentor::class);
            $table->dropColumn('mentor_id');
        });
    }
};
