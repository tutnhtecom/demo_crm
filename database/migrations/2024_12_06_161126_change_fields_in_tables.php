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
        if (Schema::hasTable('leads') && Schema::hasColumn('leads', 'academic_terms_id')) {
            Schema::table('leads', function (Blueprint $table) {
                $table->bigInteger('academic_terms_id')->nullable()->default(NULL)->comment('Lưu mã niên khóa')->change();
            });
        }
        
        if (Schema::hasTable('students') && !Schema::hasColumn('students', 'academic_terms_id')) {
            Schema::table('students', function (Blueprint $table) {
                $table->bigInteger('academic_terms_id')->nullable()->after('marjors_id')->default(NULL)->comment('Lưu mã niên khóa');
            });
        }    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('leads') && Schema::hasColumn('leads', 'academic_terms_id')) {
            Schema::table('leads', function (Blueprint $table) {
                $table->bigInteger('academic_terms_id')->nullable()->default(NULL)->comment('Lưu mã niên khóa')->change();
            });
        }
        
        if (Schema::hasTable('students') && !Schema::hasColumn('students', 'academic_terms_id')) {
            Schema::table('students', function (Blueprint $table) {
                $table->bigInteger('academic_terms_id')->nullable()->after('marjors_id')->default(NULL)->comment('Lưu mã niên khóa');
            });
        }    
    }
};
