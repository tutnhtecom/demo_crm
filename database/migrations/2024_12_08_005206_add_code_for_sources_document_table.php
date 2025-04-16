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
        if(Schema::hasTable('sources_documents') && !Schema::hasColumn('sources_documents','code')){
            Schema::table('sources_documents', function (Blueprint $table) {                    
                $table->string('code')->nullable(false)->after('id')->comment('Lưu code của hợp đồng');                
            });            
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('sources_documents') && !Schema::hasColumn('sources_documents','code')){
            Schema::table('sources_documents', function (Blueprint $table) {                    
                $table->string('code')->nullable(false)->after('id')->comment('Lưu code của hợp đồng');                
            });            
        }
    }
};
