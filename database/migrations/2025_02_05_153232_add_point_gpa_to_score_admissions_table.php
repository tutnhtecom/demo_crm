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
        if(Schema::hasTable('score_adminssions') && !Schema::hasColumn('score_adminssions', 'semesters_id')) {
            Schema::table('score_adminssions', function($table) {
                $table->integer('point_gpa')->nullable(TRUE)->default(NULL)->after('marjors_id')->comment('Hệ số của phương thức xét tuyển');                
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('score_adminssions') && !Schema::hasColumn('score_adminssions', 'semesters_id')) {
            Schema::table('score_adminssions', function($table) {
                $table->integer('point_gpa')->nullable(TRUE)->default(NULL)->after('marjors_id')->comment('Hệ số của phương thức xét tuyển');                
            });
        }
    }
};
