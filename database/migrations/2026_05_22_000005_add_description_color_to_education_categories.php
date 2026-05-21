<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('education_categories', function (Blueprint $table) {
            $table->text('description')->nullable()->after('slug');
            $table->string('color', 30)->nullable()->after('description');
        });
    }

    public function down()
    {
        Schema::table('education_categories', function (Blueprint $table) {
            $table->dropColumn(['description', 'color']);
        });
    }
};
