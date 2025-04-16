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
        if(Schema::hasTable('supports') && !Schema::hasColumn('supports','answers')){
            Schema::table('supports', function (Blueprint $table) {                    
                $table->text('answers')->nullable(TRUE)->default(NULL)->after('descriptions')->comment('Lưu câu trả lời');                
            });            
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('supports') && !Schema::hasColumn('supports','answers')){
            Schema::table('supports', function (Blueprint $table) {                    
                $table->text('answers')->nullable(TRUE)->default(NULL)->after('descriptions')->comment('Lưu câu trả lời');                
            });            
        }
    }
};
