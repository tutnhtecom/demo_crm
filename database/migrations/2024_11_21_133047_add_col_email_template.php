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
        if(Schema::hasTable('email_templates') && !Schema::hasColumn('email_templates','is_default')){
            Schema::table('email_templates', function (Blueprint $table) {                    
                $table->tinyInteger('is_default')->nullable()->default(0)->after('file_name')->comment('Lưu loại đối tượng hỗ trợ: 0: Không mặc định, 1: mặc định');
            });            
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('email_templates') && !Schema::hasColumn('email_templates','is_default')){
            Schema::table('email_templates', function (Blueprint $table) {                    
                $table->tinyInteger('is_default')->nullable()->default(0)->after('file_name')->comment('Lưu loại đối tượng hỗ trợ: 0: Không mặc định, 1: mặc định');
            });            
        }
    }
};
