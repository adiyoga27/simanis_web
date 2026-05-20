<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assessment_groups', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('assessment_sub_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_group_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('assessment_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_sub_group_id')->constrained()->cascadeOnDelete();
            $table->string('text');
            $table->string('image')->nullable();
            $table->integer('score')->default(0);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('assessment_rules', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('conditions');
            $table->text('result_text');
            $table->enum('severity', ['normal', 'ringan', 'sedang', 'tinggi'])->default('normal');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('assessment_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('total_score')->default(0);
            $table->json('group_scores')->nullable();
            $table->json('matched_rules')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('assessment_result_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_result_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assessment_option_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assessment_group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assessment_sub_group_id')->constrained()->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assessment_result_options');
        Schema::dropIfExists('assessment_results');
        Schema::dropIfExists('assessment_rules');
        Schema::dropIfExists('assessment_options');
        Schema::dropIfExists('assessment_sub_groups');
        Schema::dropIfExists('assessment_groups');
    }
};
