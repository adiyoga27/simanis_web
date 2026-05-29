<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessment_conclusion_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conclusion_id')->constrained('assessment_conclusions')->cascadeOnDelete();
            $table->foreignId('rule_category_id')->constrained('assessment_rule_categories')->cascadeOnDelete();
            $table->integer('min_matched_rules')->default(1);
            $table->string('target_severity')->nullable();
            $table->timestamps();
        });

        Schema::table('assessment_conclusions', function (Blueprint $table) {
            $table->dropForeign(['rule_category_id']);
            $table->dropColumn(['rule_category_id', 'min_matched_rules', 'target_severity']);
        });
    }

    public function down(): void
    {
        Schema::table('assessment_conclusions', function (Blueprint $table) {
            $table->foreignId('rule_category_id')->nullable()->after('description')->constrained('assessment_rule_categories')->nullOnDelete();
            $table->integer('min_matched_rules')->default(1)->after('rule_category_id');
            $table->string('target_severity')->nullable()->after('min_matched_rules');
        });

        Schema::dropIfExists('assessment_conclusion_conditions');
    }
};
