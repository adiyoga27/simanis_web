<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assessment_conclusions', function (Blueprint $table) {
            $table->foreignId('rule_category_id')->nullable()->after('description')->constrained('assessment_rule_categories')->nullOnDelete();
            $table->integer('min_matched_rules')->default(1)->after('rule_category_id');
            $table->string('target_severity')->nullable()->after('min_matched_rules');

            $table->dropColumn(['score_mode', 'conditions', 'selected_groups', 'min_score', 'max_score']);
        });
    }

    public function down(): void
    {
        Schema::table('assessment_conclusions', function (Blueprint $table) {
            $table->string('score_mode')->default('per_group');
            $table->json('conditions')->nullable();
            $table->json('selected_groups')->nullable();
            $table->integer('min_score')->nullable();
            $table->integer('max_score')->nullable();

            $table->dropForeign(['rule_category_id']);
            $table->dropColumn(['rule_category_id', 'min_matched_rules', 'target_severity']);
        });
    }
};
