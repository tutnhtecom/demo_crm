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
        if(Schema::hasTable('dvlk_semesters') && !Schema::hasColumn('dvlk_semesters', 'types')) {
            Schema::table('dvlk_semesters', function($table) {
                $table->tinyInteger('types')->nullable(TRUE)->default(NULL)->after('admission_date')
                      ->comment('Lưu kiểu bản ghi: 0: Cho tuyển sinh, 1: Cho import học phí');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('dvlk_semesters') && !Schema::hasColumn('dvlk_semesters', 'types')) {
            Schema::table('dvlk_semesters', function($table) {
                $table->tinyInteger('types')->nullable(TRUE)->default(NULL)->after('admission_date')
                      ->comment('Lưu kiểu bản ghi: 0: Cho tuyển sinh, 1: Cho import học phí');
            });
        }
    }
};
