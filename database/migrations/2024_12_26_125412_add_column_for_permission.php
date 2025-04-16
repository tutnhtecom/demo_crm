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
        if(Schema::hasTable('permissions') && Schema::hasColumn('permissions', 'router_web_name')) {
            Schema::table('permissions', function($table) {
                $table->dropColumn('router_web_name');
            });
        }
        if(Schema::hasTable('permissions') && !Schema::hasColumn('permissions','router_web_name')){
            Schema::table('permissions', function (Blueprint $table) {                    
                $table->string('router_web_name')->nullable(TRUE)->default(NULL)->after('router_name')->comment('Luu router web name');                
            });            
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('permissions') && Schema::hasColumn('permissions', 'router_web_name')) {
            Schema::table('permissions', function($table) {
                $table->dropColumn('router_web_name');
            });
        }
        if(Schema::hasTable('permissions') && !Schema::hasColumn('permissions','router_web_name')){
            Schema::table('permissions', function (Blueprint $table) {                    
                $table->string('router_web_name')->nullable(TRUE)->default(NULL)->after('router_name')->comment('Luu router web name');                
            });            
        }
    }
};
