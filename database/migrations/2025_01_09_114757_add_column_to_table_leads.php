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
        if(Schema::hasTable('leads') && Schema::hasColumn('leads', 'd_email_status')) {
            Schema::table('leads', function($table) {
                $table->dropColumn('d_email_status');
            });
        }
        if(Schema::hasTable('leads') && !Schema::hasColumn('leads','d_email_status')){
            Schema::table('leads', function (Blueprint $table) {                    
                $table->tinyInteger('d_email_status')->nullable(TRUE)->default(NULL)->after('active_student')->comment('Lưu trạng thái trùng lặp email: 0: không trùng, 1: trùng');                
            });            
        }

        if(Schema::hasTable('leads') && Schema::hasColumn('leads', 'parent_id')) {
            Schema::table('leads', function($table) {
                $table->dropColumn('parent_id');
            });
        }
        if(Schema::hasTable('leads') && !Schema::hasColumn('leads','parent_id')){
            Schema::table('leads', function (Blueprint $table) {                    
                $table->bigInteger('parent_id')->nullable(TRUE)->default(NULL)->after('id')->comment('Lưu id cha của sinh viên');                
            });            
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('leads') && Schema::hasColumn('leads', 'd_email_status')) {
            Schema::table('leads', function($table) {
                $table->dropColumn('d_email_status');
            });
        }
        if(Schema::hasTable('leads') && !Schema::hasColumn('leads','d_email_status')){
            Schema::table('leads', function (Blueprint $table) {                    
                $table->tinyInteger('d_email_status')->nullable(TRUE)->default(NULL)->after('active_student')->comment('Lưu trạng thái trùng lặp email: 0: không trùng, 1: trùng');                
            });            
        }

        if(Schema::hasTable('leads') && Schema::hasColumn('leads', 'parent_id')) {
            Schema::table('leads', function($table) {
                $table->dropColumn('parent_id');
            });
        }
        if(Schema::hasTable('leads') && !Schema::hasColumn('leads','parent_id')){
            Schema::table('leads', function (Blueprint $table) {                    
                $table->bigInteger('parent_id')->nullable(TRUE)->default(NULL)->after('id')->comment('Lưu id cha của sinh viên');                
            });            
        }
    }
};
