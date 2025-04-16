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
        if(Schema::hasTable('block_adminssions') && !Schema::hasColumn('block_adminssions','marjors_id')){
            Schema::table('block_adminssions', function (Blueprint $table) {                    
                $table->bigInteger('marjors_id')->unsigned()->nullable(TRUE)->default(null)->after('id')->comment('Lưu id của chuyên ngành');
                $table->foreign('marjors_id')->references('id')->on('marjors')->onDelete('cascade');
            });            
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('block_adminssions') && !Schema::hasColumn('block_adminssions','marjors_id')){
            Schema::table('block_adminssions', function (Blueprint $table) {                    
                $table->bigInteger('marjors_id')->unsigned()->nullable(TRUE)->default(null)->after('id')->comment('Lưu id của chuyên ngành');
                $table->foreign('marjors_id')->references('id')->on('marjors')->onDelete('cascade');
            });            
        }
    }
};
