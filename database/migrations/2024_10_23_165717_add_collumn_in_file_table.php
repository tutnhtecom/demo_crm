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
        if(Schema::hasTable('files') && !Schema::hasColumn('files','price_list_id')){
            Schema::table('files', function (Blueprint $table) {                    
                $table->bigInteger('price_list_id')->nullable()->default(NULL)->after('employees_id')->comment('Lưu mã màu của border');
            });            
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('files') && !Schema::hasColumn('files','price_list_id')){
            Schema::table('files', function (Blueprint $table) {                    
                $table->bigInteger('price_list_id')->nullable()->default(NULL)->after('employees_id')->comment('Lưu mã màu của border');
            });            
        }
    }
};
