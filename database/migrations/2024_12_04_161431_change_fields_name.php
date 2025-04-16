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
        if(Schema::hasTable('sources_rate') && !Schema::hasColumn('sources_rate','payment_manager_rate')){
            Schema::table('sources_rate', function (Blueprint $table) {
                $table->double('payment_manager_rate')->nullable(TRUE)->default(0)->after('expense_name')->comment('Lưu định mức thanh toán cho cán bộ ');
            });         
        } 
        if(Schema::hasTable('sources_rate') && !Schema::hasColumn('sources_rate','payment_manager_price')){
            Schema::table('sources_rate', function (Blueprint $table) {
                $table->double('payment_manager_price')->nullable(TRUE)->default(0)->after('expense_name')->comment('Lưu định mức thanh toán cho cán bộ ');
            });         
        }     
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('sources_rate') && !Schema::hasColumn('sources_rate','payment_manager_rate')){
            Schema::table('sources_rate', function (Blueprint $table) {
                $table->double('payment_manager_rate')->nullable(TRUE)->default(0)->after('expense_name')->comment('Lưu định mức thanh toán cho cán bộ ');
            });         
        }    
        if(Schema::hasTable('sources_rate') && !Schema::hasColumn('sources_rate','payment_manager_price')){
            Schema::table('sources_rate', function (Blueprint $table) {
                $table->double('payment_manager_price')->nullable(TRUE)->default(0)->after('expense_name')->comment('Lưu định mức thanh toán cho cán bộ ');
            });         
        }       
    }
};
