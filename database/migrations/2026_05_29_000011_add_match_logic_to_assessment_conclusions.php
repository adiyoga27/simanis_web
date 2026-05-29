<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assessment_conclusions', function (Blueprint $table) {
            $table->string('match_logic')->default('and')->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('assessment_conclusions', function (Blueprint $table) {
            $table->dropColumn('match_logic');
        });
    }
};
