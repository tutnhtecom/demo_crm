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
        if(Schema::hasTable('lst_status') && !Schema::hasColumn('lst_status','is_default')){
            Schema::table('lst_status', function (Blueprint $table) {                    
                $table->tinyInteger('is_default')->nullable(TRUE)->default(0)->after('id')->comment('Lưu Giá trị mặc định của status: 0 không mặc định, 1: mặc đinh cấm xóa cấm sửa');                
            });            
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('lst_status') && !Schema::hasColumn('lst_status','is_default')){
            Schema::table('lst_status', function (Blueprint $table) {                    
                $table->tinyInteger('is_default')->nullable(TRUE)->default(0)->after('id')->comment('Lưu Giá trị mặc định của status: 0 không mặc định, 1: mặc đinh cấm xóa cấm sửa');                
            });            
        }
    }
};
