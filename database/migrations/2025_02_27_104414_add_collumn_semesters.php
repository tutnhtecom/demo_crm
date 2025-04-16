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
        if(Schema::hasTable('dvlk_semesters') && !Schema::hasColumn('dvlk_semesters', 'academy_id')) {
            Schema::table('dvlk_semesters', function($table) {
                $table->bigInteger('academy_id')->nullable(TRUE)->default(NULL)->after('id')->comment('Lưu id của khóa');                
            });
        }
        if(Schema::hasTable('dvlk_semesters') && !Schema::hasColumn('dvlk_semesters', 'admission_date')) {
            Schema::table('dvlk_semesters', function($table) {
                $table->date('admission_date')->nullable(TRUE)->default(NULL)->after('semesters_full_year')->comment('Lưu ngày tuyến sinh');
            });
        }
        if(Schema::hasTable('dvlk_semesters') && !Schema::hasColumn('dvlk_semesters', 'note')) {
            Schema::table('dvlk_semesters', function($table) {
                $table->text('note')->nullable(TRUE)->default(NULL)->after('admission_date')->comment('Lưu ghi chú');                
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('dvlk_semesters') && !Schema::hasColumn('dvlk_semesters', 'academy_id')) {
            Schema::table('dvlk_semesters', function($table) {
                $table->bigInteger('academy_id')->nullable(TRUE)->default(NULL)->after('id')->comment('Lưu id của khóa');                
            });
        }
        if(Schema::hasTable('dvlk_semesters') && !Schema::hasColumn('dvlk_semesters', 'admission_date')) {
            Schema::table('dvlk_semesters', function($table) {
                $table->date('admission_date')->nullable(TRUE)->default(NULL)->after('semesters_full_year')->comment('Lưu ngày tuyến sinh');
            });
        }
        if(Schema::hasTable('dvlk_semesters') && !Schema::hasColumn('dvlk_semesters', 'note')) {
            Schema::table('dvlk_semesters', function($table) {
                $table->text('note')->nullable(TRUE)->default(NULL)->after('admission_date')->comment('Lưu ghi chú');                
            });
        }
    }
};
