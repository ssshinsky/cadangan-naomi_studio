<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('open_classes', function (Blueprint $table) {
            $table->foreignId('mentor_id')->nullable()->after('created_by')->constrained('mentors')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('open_classes', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['mentor_id']);
            $table->dropColumn('mentor_id');
        });
    }
};
