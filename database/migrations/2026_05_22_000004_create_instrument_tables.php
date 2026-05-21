<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('instrument_groups', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('instrument_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instrument_group_id')->constrained()->cascadeOnDelete();
            $table->text('question');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('instrument_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('total_score')->default(0);
            $table->integer('max_score')->default(0);
            $table->decimal('percentage', 5, 2)->default(0);
            $table->string('interpretation');
            $table->json('answers');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('instrument_results');
        Schema::dropIfExists('instrument_questions');
        Schema::dropIfExists('instrument_groups');
    }
};
