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
        if(Schema::hasTable('lst_status') && !Schema::hasColumn('lst_status','border_color')){
            Schema::table('lst_status', function (Blueprint $table) {                    
                $table->string('border_color')->nullable()->default(NULL)->after('color')->comment('Lưu mã màu của border');
            });            
        }
        if(Schema::hasTable('lst_status') && !Schema::hasColumn('lst_status','bg_color')){
            Schema::table('lst_status', function (Blueprint $table) {                    
                $table->string('bg_color')->nullable()->default(NULL)->after('color')->comment('Lưu mã màu background');
            });            
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('lst_status') && !Schema::hasColumn('lst_status','border_color')){
            Schema::table('lst_status', function (Blueprint $table) {                    
                $table->string('border_color')->nullable()->default(NULL)->after('color')->comment('Lưu mã màu của border');
            });            
        }
        if(Schema::hasTable('lst_status') && !Schema::hasColumn('lst_status','bg_color')){
            Schema::table('lst_status', function (Blueprint $table) {                    
                $table->string('bg_color')->nullable()->default(NULL)->after('color')->comment('Lưu mã màu background');
            });            
        }
    }
};
