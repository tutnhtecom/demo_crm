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
        if (Schema::hasColumn('transactions', 'semesters_id')) {            
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_NAME = 'transactions'
                AND COLUMN_NAME = 'semesters_id'
                AND TABLE_SCHEMA = DATABASE();
            ");
            // dd($foreignKeys);
            if(isset($foreignKeys) && count($foreignKeys)) {
                foreach ($foreignKeys as $value) {
                    if($value->CONSTRAINT_NAME == "transactions_semesters_id_foreign") {
                        if (!empty($foreignKeys)) {
                            Schema::table('transactions', function (Blueprint $table) {
                                $table->dropForeign(['semesters_id']); // Use array notation
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
        if (Schema::hasColumn('transactions', 'semesters_id')) {            
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_NAME = 'transactions'
                AND COLUMN_NAME = 'semesters_id'
                AND TABLE_SCHEMA = DATABASE();
            ");
            // dd($foreignKeys);
            if(isset($foreignKeys) && count($foreignKeys)) {
                foreach ($foreignKeys as $value) {
                    if($value->CONSTRAINT_NAME == "transactions_semesters_id_foreign") {
                        if (!empty($foreignKeys)) {
                            Schema::table('transactions', function (Blueprint $table) {
                                $table->dropForeign(['semesters_id']); // Use array notation
                            });
                        } 
                    } 
                }
            }
                        
        }
    }
};
