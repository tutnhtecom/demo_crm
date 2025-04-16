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
        if(Schema::hasTable('sources_rate') && !Schema::hasColumn('sources_rate','payment_terms_note')){
            Schema::table('sources_rate', function (Blueprint $table) {                    
                $table->string('payment_terms_note')->nullable(TRUE)->default(Null)->after('math_sign')->comment('');                                
            });            
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('sources_rate') && !Schema::hasColumn('sources_rate','payment_terms_note')){
            Schema::table('sources_rate', function (Blueprint $table) {                    
                $table->string('payment_terms_note')->nullable(TRUE)->default(Null)->after('math_sign')->comment('Lưu Giá trị mặc định của status: 0 không mặc định, 1: mặc đinh cấm xóa cấm sửa');                
            });            
        }
    }
};
