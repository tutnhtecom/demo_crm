<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if(Schema::hasTable('dvlk_students') && !Schema::hasColumn('dvlk_students', 'students_sources_id')) {
            Schema::table('dvlk_students', function($table) {
                $table->tinyInteger('students_sources_id')->nullable(TRUE)->default(NULL)->after('students_sources')
                    ->comment('Lưu id của đơn vị liên kết');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('dvlk_students') && !Schema::hasColumn('dvlk_students', 'students_sources_id')) {
            Schema::table('dvlk_students', function($table) {
                $table->tinyInteger('students_sources_id')->nullable(TRUE)->default(NULL)->after('students_sources')
                    ->comment('Lưu id của đơn vị liên kết');
            });
        }
    }
};
