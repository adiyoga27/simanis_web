<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assessment_conclusions', function (Blueprint $table) {
            $table->string('reference_link', 2048)->nullable()->after('result_text');
        });
    }

    public function down(): void
    {
        Schema::table('assessment_conclusions', function (Blueprint $table) {
            $table->dropColumn('reference_link');
        });
    }
};
