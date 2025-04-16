<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('price_lists', 'academic_terms_id')) {            
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_NAME = 'price_lists'
                AND COLUMN_NAME = 'academic_terms_id'
                AND TABLE_SCHEMA = DATABASE();
            ");            
            if(isset($foreignKeys) && count($foreignKeys)) {
                foreach ($foreignKeys as $value) {
                    if($value->CONSTRAINT_NAME == "price_lists_academic_terms_id_foreign") {
                        if (!empty($foreignKeys)) {
                            Schema::table('price_lists', function (Blueprint $table) {
                                $table->dropForeign(['academic_terms_id']); // Use array notation
                            });
                        } 
                    } 
                }
            }
                        
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('price_lists', 'academic_terms_id')) {            
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_NAME = 'price_lists'
                AND COLUMN_NAME = 'academic_terms_id'
                AND TABLE_SCHEMA = DATABASE();
            ");            
            if(isset($foreignKeys) && count($foreignKeys)) {
                foreach ($foreignKeys as $value) {
                    if($value->CONSTRAINT_NAME == "price_lists_academic_terms_id_foreign") {
                        if (!empty($foreignKeys)) {
                            Schema::table('price_lists', function (Blueprint $table) {
                                $table->dropForeign(['academic_terms_id']); // Use array notation
                            });
                        } 
                    } 
                }
            }
                        
        }
    }
};
