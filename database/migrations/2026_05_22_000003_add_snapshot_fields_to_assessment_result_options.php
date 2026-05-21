<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('assessment_result_options', function (Blueprint $table) {
            $table->string('option_text')->nullable()->after('assessment_sub_group_id');
            $table->integer('option_score')->nullable()->after('option_text');
            $table->string('option_image')->nullable()->after('option_score');
        });
    }

    public function down()
    {
        Schema::table('assessment_result_options', function (Blueprint $table) {
            $table->dropColumn(['option_text', 'option_score', 'option_image']);
        });
    }
};
