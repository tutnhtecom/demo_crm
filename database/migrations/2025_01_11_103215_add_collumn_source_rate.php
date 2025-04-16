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
        if(Schema::hasTable('sources_rate') && !Schema::hasColumn('sources_rate', 'semesters_id')) {
            Schema::table('sources_rate', function($table) {
                $table->bigInteger('semesters_id')->nullable(TRUE)->default(NULL)->after('sources_documents_id')->comment('Luu id cua hoc ki');                
            });
        }
        if(Schema::hasTable('sources_rate') && !Schema::hasColumn('sources_rate', 'academic_terms_id')) {
            Schema::table('sources_rate', function($table) {
                $table->bigInteger('academic_terms_id')->nullable(TRUE)->default(NULL)->after('sources_documents_id')->comment('Luu id cua nien khoa');                
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('sources_rate') && !Schema::hasColumn('sources_rate', 'semesters_id')) {
            Schema::table('sources_rate', function($table) {
                $table->bigInteger('semesters_id')->nullable(TRUE)->default(NULL)->after('sources_documents_id')->comment('Luu id cua hoc ki');                
            });
        }
        if(Schema::hasTable('sources_rate') && !Schema::hasColumn('sources_rate', 'academic_terms_id')) {
            Schema::table('sources_rate', function($table) {
                $table->bigInteger('academic_terms_id')->nullable(TRUE)->default(NULL)->after('sources_documents_id')->comment('Luu id cua nien khoa');                
            });
        }
    }
};
