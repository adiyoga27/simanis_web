<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tnt_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('jk', 1);
            $table->integer('height');
            $table->integer('weight');
            $table->integer('age');
            $table->integer('activity');
            $table->integer('weight_status');
            $table->float('bmi', 8, 2);
            $table->float('bbi', 8, 2);
            $table->float('calorie_needs', 8, 2);
            $table->foreignId('diet_id')->nullable()->constrained('diets')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tnt_calculations');
    }
};
