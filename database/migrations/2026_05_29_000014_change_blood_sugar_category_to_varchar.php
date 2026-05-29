<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('blood_sugar_records', function (Blueprint $table) {
            $table->string('category', 50)->change();
        });
    }

    public function down()
    {
        Schema::table('blood_sugar_records', function (Blueprint $table) {
            $table->enum('category', ['normal', 'high', 'very_high', 'low', 'very_low'])->change();
        });
    }
};
