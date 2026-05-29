<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assessment_conclusion_conditions', function (Blueprint $table) {
            $table->string('logic')->default('and')->after('target_severity');
        });
    }

    public function down(): void
    {
        Schema::table('assessment_conclusion_conditions', function (Blueprint $table) {
            $table->dropColumn('logic');
        });
    }
};
