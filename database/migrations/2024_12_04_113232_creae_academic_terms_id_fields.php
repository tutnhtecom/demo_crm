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
        if(Schema::hasTable('leads') && !Schema::hasColumn('leads', 'academic_terms_id')){
            Schema::table('leads', function (Blueprint $table) {
                $table->bigInteger('academic_terms_id')->unsigned()->nullable(FALSE)->after('marjors_id')->comment('Lưu id của niên khóa academic_terms');                
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('leads') && !Schema::hasColumn('leads', 'academic_terms_id')){
            Schema::table('leads', function (Blueprint $table) {
                $table->bigInteger('academic_terms_id')->unsigned()->nullable(FALSE)->after('marjors_id')->comment('Lưu id của niên khóa academic_terms');                
            });
        }
    }
};
