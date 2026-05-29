<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessment_rule_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::table('assessment_rules', function (Blueprint $table) {
            $table->foreignId('rule_category_id')->nullable()->after('id')->constrained('assessment_rule_categories')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('assessment_rules', function (Blueprint $table) {
            $table->dropForeign(['rule_category_id']);
            $table->dropColumn('rule_category_id');
        });
        Schema::dropIfExists('assessment_rule_categories');
    }
};
