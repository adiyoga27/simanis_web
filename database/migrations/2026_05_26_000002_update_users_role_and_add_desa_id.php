<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Step 1: Expand enum to include all old + new values
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','user','superadmin','kepala_puskesmas','kepala_desa','kader','pasien') DEFAULT 'pasien'");

        // Step 2: Migrate old values to new values
        DB::statement("UPDATE users SET role = 'superadmin' WHERE role = 'admin'");
        DB::statement("UPDATE users SET role = 'pasien' WHERE role = 'user'");

        // Step 3: Shrink enum to only new values
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin','kepala_puskesmas','kepala_desa','kader','pasien') DEFAULT 'pasien'");

        // Step 4: Add desa_id foreign key
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('desa_id')->nullable()->after('role')->constrained('desas')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['desa_id']);
            $table->dropColumn('desa_id');
        });

        // Expand to include all values
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','user','superadmin','kepala_puskesmas','kepala_desa','kader','pasien') DEFAULT 'user'");

        // Revert to old values
        DB::statement("UPDATE users SET role = 'admin' WHERE role = 'superadmin'");
        DB::statement("UPDATE users SET role = 'user' WHERE role IN ('kepala_puskesmas','kepala_desa','kader','pasien')");

        // Shrink to old enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','user') DEFAULT 'user'");
    }
};
