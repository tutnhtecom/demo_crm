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
        if(Schema::hasTable('kpis_reports') && !Schema::hasColumn('kpis_reports','status')){
            Schema::table('kpis_reports', function (Blueprint $table) {                    
                $table->integer('status')->nullable(TRUE)->default(0)->after('price')->comment('Lưu trạng thái của giao dịch');
            });            
        }
        if(Schema::hasTable('kpis_reports') && !Schema::hasColumn('kpis_reports','transactions_id')){
            Schema::table('kpis_reports', function (Blueprint $table) {                    
                $table->integer('transactions_id')->nullable(TRUE)->default(null)->after('price')->comment('Lưu trạng thái của giao dịch');
            });            
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('kpis_reports') && !Schema::hasColumn('kpis_reports','status')){
            Schema::table('kpis_reports', function (Blueprint $table) {                    
                $table->integer('status')->nullable(TRUE)->default(0)->after('price')->comment('Lưu trạng thái của giao dịch');
            });            
        }
        if(Schema::hasTable('kpis_reports') && !Schema::hasColumn('kpis_reports','transactions_id')){
            Schema::table('kpis_reports', function (Blueprint $table) {                    
                $table->integer('transactions_id')->nullable(TRUE)->default(null)->after('price')->comment('Lưu trạng thái của giao dịch');
            });            
        }
    }
};
