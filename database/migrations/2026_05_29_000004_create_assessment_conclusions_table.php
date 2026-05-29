<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessment_conclusions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('score_mode')->default('per_group');
            $table->json('conditions')->nullable();
            $table->json('selected_groups')->nullable();
            $table->integer('min_score')->nullable();
            $table->integer('max_score')->nullable();
            $table->text('result_text');
            $table->string('color', 30)->nullable();
            $table->string('severity')->default('normal');
            $table->integer('priority')->default(0);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_conclusions');
    }
};
