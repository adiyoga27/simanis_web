<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('foot_screening_results', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('assessment_results', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('blood_sugar_records', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('instrument_results', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('foot_screening_results', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('assessment_results', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('blood_sugar_records', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('instrument_results', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
