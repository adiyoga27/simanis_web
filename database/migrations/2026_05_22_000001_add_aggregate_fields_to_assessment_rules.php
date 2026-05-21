<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('assessment_rules', function (Blueprint $table) {
            $table->string('score_mode')->default('per_group')->after('conditions');
            $table->json('selected_groups')->nullable()->after('score_mode');
            $table->string('color', 30)->nullable()->after('result_text');
            $table->integer('min_score')->nullable()->after('color');
            $table->integer('max_score')->nullable()->after('min_score');
        });
    }

    public function down()
    {
        Schema::table('assessment_rules', function (Blueprint $table) {
            $table->dropColumn(['score_mode', 'selected_groups', 'color', 'min_score', 'max_score']);
        });
    }
};
