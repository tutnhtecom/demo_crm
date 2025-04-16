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
        if(Schema::hasTable('semesters') && Schema::hasColumn('semesters','semesters_year')){
            Schema::table('semesters', function (Blueprint $table) {
                $table->dropColumn('semesters_year');        
            });         
        }
        if(Schema::hasTable('semesters') && !Schema::hasColumn('semesters','academic_terms_id')){
            Schema::table('semesters', function (Blueprint $table) {
                $table->bigInteger('academic_terms_id')->unsigned()->nullable(false)->after('name')->comment('Lưu id của academic_terms làm khóa phụ');
                $table->foreign('academic_terms_id')->references('id')->on('academic_terms')->onDelete('cascade');
            });         
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('semesters') && Schema::hasColumn('semesters','semesters_year')){
            Schema::table('semesters', function (Blueprint $table) {
                $table->dropColumn('semesters_year');        
            });         
        }
        if(Schema::hasTable('semesters') && !Schema::hasColumn('semesters','academic_terms_id')){
            Schema::table('semesters', function (Blueprint $table) {
                $table->bigInteger('academic_terms_id')->nullable(false)->after('name')->comment('Lưu id của academic_terms làm khóa phụ');
                $table->foreign('academic_terms_id')->references('id')->on('academic_terms')->onDelete('cascade');
            });         
        }
    }
};
