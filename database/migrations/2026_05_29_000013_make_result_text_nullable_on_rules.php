<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assessment_rules', function (Blueprint $table) {
            $table->text('result_text')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('assessment_rules', function (Blueprint $table) {
            $table->text('result_text')->nullable(false)->change();
        });
    }
};
