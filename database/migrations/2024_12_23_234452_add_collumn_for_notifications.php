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
        if(Schema::hasTable('notifications') && !Schema::hasColumn('notifications','is_open')){
            Schema::table('notifications', function (Blueprint $table) {                    
                $table->tinyInteger('is_open')->nullable(TRUE)->default(0)->after('status')->comment('Store status ready for notications: O: not reads, 1: readed');                
            });            
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('notifications') && !Schema::hasColumn('notifications','is_open')){
            Schema::table('notifications', function (Blueprint $table) {                    
                $table->tinyInteger('is_open')->nullable(TRUE)->default(0)->after('status')->comment('Store status ready for notications: O: not reads, 1: readed');                
            });            
        }
    }
};

