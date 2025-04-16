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
        if(Schema::hasTable('sources_rate') && !Schema::hasColumn('sources_rate','sources_documents_id')){
            Schema::table('sources_rate', function (Blueprint $table) {                    
                $table->bigInteger('sources_documents_id')->unsigned()->nullable()->default(NULl)->after('sources_id')->comment('Lưu id của hợp đồng');
                $table->foreign('sources_documents_id')->references('id')->on('sources_documents')->onDelete('cascade');
            });            
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('sources_rate') && !Schema::hasColumn('sources_rate','sources_documents_id')){
            Schema::table('sources_rate', function (Blueprint $table) {                    
                $table->bigInteger('sources_documents_id')->unsigned()->nullable()->default(NULl)->after('sources_id')->comment('Lưu id của hợp đồng');
                $table->foreign('sources_documents_id')->references('id')->on('sources_documents')->onDelete('cascade');
            });            
        }
    }
};
