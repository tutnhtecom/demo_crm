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
        if(Schema::hasTable('sources')){    
            if(Schema::hasColumn('sources','signed_document')) {
                Schema::table('sources', function($table) {
                    $table->dropColumn('signed_document');
                });
                
            }
            if(Schema::hasColumn('sources','signed_content')) {
                Schema::table('sources', function($table) {
                    $table->dropColumn('signed_content');
                });
            }

            if(Schema::hasColumn('sources','signed_from_date')) {
                Schema::table('sources', function($table) {
                    $table->dropColumn('signed_from_date');
                });
            }
            if(Schema::hasColumn('sources','signed_to_date')) {
                Schema::table('sources', function($table) {
                    $table->dropColumn('signed_to_date');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('sources')){    
            if(Schema::hasColumn('sources','signed_document')) {
                Schema::table('sources', function($table) {
                    $table->dropColumn('signed_document');
                });
                
            }
            if(Schema::hasColumn('sources','signed_content')) {
                Schema::table('sources', function($table) {
                    $table->dropColumn('signed_content');
                });
            }

            if(Schema::hasColumn('sources','signed_from_date')) {
                Schema::table('sources', function($table) {
                    $table->dropColumn('signed_from_date');
                });
            }
            if(Schema::hasColumn('sources','signed_to_date')) {
                Schema::table('sources', function($table) {
                    $table->dropColumn('signed_to_date');
                });
            }
        }
    }
};
