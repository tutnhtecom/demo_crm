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
        if(Schema::hasTable('leads') && !Schema::hasColumn('leads','extended_fields')){
            Schema::table('leads', function (Blueprint $table) {                    
                $table->text('extended_fields')->nullable()->default(null)->after('tags_id')->comment('Luu cac truong mo rong khi imports');
            });            
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('leads') && !Schema::hasColumn('leads','extended_fields')){
            Schema::table('leads', function (Blueprint $table) {                    
                $table->text('extended_fields')->nullable()->default(null)->after('tags_id')->comment('Luu cac truong mo rong khi imports');
            });            
        }
    }
};
