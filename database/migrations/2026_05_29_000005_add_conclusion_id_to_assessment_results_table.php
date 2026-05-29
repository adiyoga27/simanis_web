<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assessment_results', function (Blueprint $table) {
            $table->foreignId('conclusion_id')->nullable()->after('matched_rules')->constrained('assessment_conclusions')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('assessment_results', function (Blueprint $table) {
            $table->dropForeign(['conclusion_id']);
            $table->dropColumn('conclusion_id');
        });
    }
};
