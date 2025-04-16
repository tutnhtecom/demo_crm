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
        if(Schema::hasTable('price_lists') && !Schema::hasColumn('price_lists','academic_terms_id')){
            Schema::table('price_lists', function (Blueprint $table) {                    
                $table->bigInteger('academic_terms_id')->nullable(TRUE)->default(NULL)->after('id')->comment('Luu id cua nien khoa');                
                // $table->foreign('academic_terms_id')->references('id')->on('academic_terms')->onDelete('cascade');
            });            
        }
        if(Schema::hasTable('price_lists') && !Schema::hasColumn('price_lists','semesters_id')){
            Schema::table('price_lists', function (Blueprint $table) {                    
                $table->bigInteger('semesters_id')->nullable(TRUE)->default(NULL)->after('id')->comment('Luu id cua hoc ky');                
                // $table->foreign('semesters_id')->references('id')->on('semesters')->onDelete('cascade');
            });            
        }
        // Them cot cho transactions
        if(Schema::hasTable('transactions') && !Schema::hasColumn('transactions','academic_terms_id')){
            Schema::table('transactions', function (Blueprint $table) {                    
                $table->bigInteger('academic_terms_id')->nullable(TRUE)->default(NULL)->after('id')->comment('Luu id cua nien khoa');                
                // $table->foreign('academic_terms_id')->references('id')->on('academic_terms')->onDelete('cascade');
            });            
        }
        if(Schema::hasTable('transactions') && !Schema::hasColumn('transactions','semesters_id')){
            Schema::table('transactions', function (Blueprint $table) {                    
                $table->bigInteger('semesters_id')->nullable(TRUE)->default(NULL)->after('id')->comment('Luu id cua hoc ky');                
                // $table->foreign('semesters_id')->references('id')->on('semesters')->onDelete('cascade');
            });            
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('price_lists') && !Schema::hasColumn('price_lists','academic_terms_id')){
            Schema::table('price_lists', function (Blueprint $table) {                    
                $table->bigInteger('academic_terms_id')->nullable(TRUE)->default(NULL)->after('id')->comment('Luu id cua nien khoa');                
                // $table->foreign('academic_terms_id')->references('id')->on('academic_terms')->onDelete('cascade');
            });            
        }
        if(Schema::hasTable('price_lists') && !Schema::hasColumn('price_lists','semesters_id')){
            Schema::table('price_lists', function (Blueprint $table) {                    
                $table->bigInteger('semesters_id')->nullable(TRUE)->default(NULL)->after('id')->comment('Luu id cua hoc ky');                
                // $table->foreign('semesters_id')->references('id')->on('semesters')->onDelete('cascade');
            });            
        }
        // Them cot cho transactions
        if(Schema::hasTable('transactions') && !Schema::hasColumn('transactions','academic_terms_id')){
            Schema::table('transactions', function (Blueprint $table) {                    
                $table->bigInteger('academic_terms_id')->nullable(TRUE)->default(NULL)->after('id')->comment('Luu id cua nien khoa');                
                // $table->foreign('academic_terms_id')->references('id')->on('academic_terms')->onDelete('cascade');
            });            
        }
        if(Schema::hasTable('transactions') && !Schema::hasColumn('transactions','semesters_id')){
            Schema::table('transactions', function (Blueprint $table) {                    
                $table->bigInteger('semesters_id')->nullable(TRUE)->default(NULL)->after('id')->comment('Luu id cua hoc ky');                
                // $table->foreign('semesters_id')->references('id')->on('semesters')->onDelete('cascade');
            });            
        }
    }
};
