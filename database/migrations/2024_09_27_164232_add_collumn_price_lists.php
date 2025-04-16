<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('price_lists') && !Schema::hasColumn('price_lists','students_id')) {
            Schema::table('price_lists', function (Blueprint $table) {
                $table->string('students_id')->nullable()->default(NULL)->after('leads_id')->comment('Lưu lại mã màu cho trạng thái');                
            });
        }
        if (Schema::hasTable('transactions') && !Schema::hasColumn('transactions','students_id')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->string('students_id')->nullable()->default(NULL)->after('leads_id')->comment('Lưu lại mã màu cho trạng thái');                
            });
        }
        if (Schema::hasTable('score_adminssions') && !Schema::hasColumn('score_adminssions','students_id')) {
            Schema::table('score_adminssions', function (Blueprint $table) {
                $table->string('students_id')->nullable()->default(NULL)->after('leads_id')->comment('Lưu lại mã màu cho trạng thái');                
            });
        }
    }   
    public function down(): void
    {
        if (Schema::hasTable('price_lists') && !Schema::hasColumn('price_lists','students_id')) {
            Schema::table('price_lists', function (Blueprint $table) {
                $table->string('students_id')->nullable()->default(NULL)->after('leads_id')->comment('Lưu lại mã màu cho trạng thái');                
            });
        }
        if (Schema::hasTable('transactions') && !Schema::hasColumn('transactions','students_id')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->string('students_id')->nullable()->default(NULL)->after('leads_id')->comment('Lưu lại mã màu cho trạng thái');                
            });
        }
        if (Schema::hasTable('score_adminssions') && !Schema::hasColumn('score_adminssions','students_id')) {
            Schema::table('score_adminssions', function (Blueprint $table) {
                $table->string('students_id')->nullable()->default(NULL)->after('leads_id')->comment('Lưu lại mã màu cho trạng thái');                
            });
        }
    }
};
