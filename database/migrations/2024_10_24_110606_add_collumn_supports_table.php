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
        if(Schema::hasTable('supports') && !Schema::hasColumn('supports','types')){
            Schema::table('supports', function (Blueprint $table) {                    
                $table->smallInteger('types')->nullable()->default(NULL)->after('code')->comment('Lưu loại đối tượng hỗ trợ: 0: Thí sinh, 1: Sinh viên, 2: Tư vấn viên');
            });            
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('supports') && !Schema::hasColumn('supports','types')){
            Schema::table('supports', function (Blueprint $table) {                    
                $table->smallInteger('types')->nullable()->default(NULL)->after('code')->comment('Lưu loại đối tượng hỗ trợ: 0: Thí sinh, 1: Sinh viên, 2: Tư vấn viên');
            });            
        }
    }
};
