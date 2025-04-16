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
        if(Schema::hasTable('leads') && !Schema::hasColumn('leads','active_student')){
            Schema::table('leads', function (Blueprint $table) {                    
                $table->smallInteger('active_student')->unsigned()->nullable()->default(0)->after('tags_id')->comment('Lưu trạng thái chuyển thành thí sinh: 0: chưa, 1: đã chuyển');
            });            
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('leads') && !Schema::hasColumn('leads','active_student')){
            Schema::table('leads', function (Blueprint $table) {                    
                $table->smallInteger('active_student')->unsigned()->nullable()->default(0)->after('tags_id')->comment('Lưu trạng thái chuyển thành thí sinh: 0: chưa, 1: đã chuyển');
            });            
        }
    }
};
