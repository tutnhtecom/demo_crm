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
        if(Schema::hasTable('kpis_reports') && !Schema::hasColumn('kpis_reports', 'academy_list_id')) {
            Schema::table('kpis_reports', function($table) {
                $table->bigInteger('academy_list_id')->nullable(TRUE)->default(null)->after('leads_id')->comment('Lưu id của Khóa tuyển sinh');
            });
        }
        if(Schema::hasTable('kpis_reports') && !Schema::hasColumn('kpis_reports', 'semesters_id')) {
            Schema::table('kpis_reports', function($table) {
                $table->bigInteger('semesters_id')->nullable(TRUE)->default(null)->after('leads_id')->comment('Lưu id của học kỳ tuyển sinh');
            });
        }
        if(Schema::hasTable('kpis_reports') && !Schema::hasColumn('kpis_reports', 'semesters_name')) {
            Schema::table('kpis_reports', function($table) {
                $table->string('semesters_name')->nullable(TRUE)->default(null)->after('semesters_id')->comment('Lưu tên của học kỳ tuyển sinh');
            });
        }
        if(Schema::hasTable('kpis_reports') && !Schema::hasColumn('kpis_reports', 'from_date')) {
            Schema::table('kpis_reports', function($table) {
                $table->date('from_date')->nullable(TRUE)->default(null)->after('semesters_name')->comment('Lưu ngày bắt đầu đóng học phí');
            });
        }
        if(Schema::hasTable('kpis_reports') && !Schema::hasColumn('kpis_reports', 'to_date')) {
            Schema::table('kpis_reports', function($table) {
                $table->date('to_date')->nullable(TRUE)->default(null)->after('semesters_name')->comment('Lưu ngày kết thúc của học kỳ');
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('kpis_reports') && !Schema::hasColumn('kpis_reports', 'academy_list_id')) {
            Schema::table('kpis_reports', function($table) {
                $table->bigInteger('academy_list_id')->nullable(TRUE)->default(null)->after('leads_id')->comment('Lưu id của Khóa tuyển sinh');
            });
        }
        if(Schema::hasTable('kpis_reports') && !Schema::hasColumn('kpis_reports', 'semesters_id')) {
            Schema::table('kpis_reports', function($table) {
                $table->bigInteger('semesters_id')->nullable(TRUE)->default(null)->after('leads_id')->comment('Lưu id của học kỳ tuyển sinh');
            });
        }
        if(Schema::hasTable('kpis_reports') && !Schema::hasColumn('kpis_reports', 'semesters_name')) {
            Schema::table('kpis_reports', function($table) {
                $table->string('semesters_name')->nullable(TRUE)->default(null)->after('semesters_id')->comment('Lưu tên của học kỳ tuyển sinh');
            });
        }
        if(Schema::hasTable('kpis_reports') && !Schema::hasColumn('kpis_reports', 'from_date')) {
            Schema::table('kpis_reports', function($table) {
                $table->date('from_date')->nullable(TRUE)->default(null)->after('semesters_name')->comment('Lưu ngày bắt đầu đóng học phí');
            });
        }
        if(Schema::hasTable('kpis_reports') && !Schema::hasColumn('kpis_reports', 'to_date')) {
            Schema::table('kpis_reports', function($table) {
                $table->date('to_date')->nullable(TRUE)->default(null)->after('semesters_name')->comment('Lưu ngày kết thúc của học kỳ');
            });
        }
    }
};
