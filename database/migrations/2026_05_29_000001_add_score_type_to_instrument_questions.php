<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('instrument_questions', function (Blueprint $table) {
            $table->enum('score_type', ['favorable', 'unfavorable'])->default('favorable')->after('question');
        });
    }

    public function down(): void
    {
        Schema::table('instrument_questions', function (Blueprint $table) {
            $table->dropColumn('score_type');
        });
    }
};
