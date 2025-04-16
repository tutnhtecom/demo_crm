<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {        
        if (Schema::hasTable('leads')) {
            Schema::table('leads', function (Blueprint $table) {
                $table->string('leads_code', 255)->nullable()->default(NULL)->after('code')->comment('Lưu mã của thí sinh');
            });
        };
        if (Schema::hasTable('students')) {
            Schema::table('students', function (Blueprint $table) {
                $table->string('students_code', 255)->nullable()->default(NULL)->after('code')->comment('Lưu mã của thí sinh');
            });
        };

        if (Schema::hasTable('students')) {
            Schema::table('students', function (Blueprint $table) {
                $table->bigInteger('assignments_id')->nullable()->default(NULL)->after('code')->comment('Lưu id của giao viên được phụ trách trong bảng sinh viên');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('leads')) {
            Schema::table('leads', function (Blueprint $table) {
                $table->string('leads_code', 255)->nullable()->default(NULL)->comment('Lưu mã của thí sinh');
            });
        };
        if (Schema::hasTable('students')) {
            Schema::table('students', function (Blueprint $table) {
                $table->string('students_code', 255)->nullable()->default(NULL)->comment('Lưu mã của thí sinh');
            });
        };

        if (Schema::hasTable('students')) {
            Schema::table('students', function (Blueprint $table) {
                $table->bigInteger('assignments_id')->nullable()->default(NULL)->comment('Lưu id của giao viên được phụ trách trong bảng sinh viên');
            });
        }
    }
};
