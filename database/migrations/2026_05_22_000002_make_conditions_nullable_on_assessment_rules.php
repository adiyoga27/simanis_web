<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('assessment_rules', function (Blueprint $table) {
            $table->json('conditions')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('assessment_rules', function (Blueprint $table) {
            $table->json('conditions')->nullable(false)->change();
        });
    }
};
