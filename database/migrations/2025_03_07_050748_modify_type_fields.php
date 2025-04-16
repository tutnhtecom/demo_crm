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
        if (Schema::hasTable('dvlk_students') && Schema::hasColumn('dvlk_students', 'students_sources_id')) {
            Schema::table('dvlk_students', function (Blueprint $table) {
                $table->bigInteger('students_sources_id')->nullable()->default(1)->comment('Lưu id trạng thái của giao dịch')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('dvlk_students') && Schema::hasColumn('dvlk_students', 'students_sources_id')) {
            Schema::table('dvlk_students', function (Blueprint $table) {
                $table->bigInteger('students_sources_id')->nullable()->default(1)->comment('Lưu id trạng thái của giao dịch')->change();
            });
        }
    }
};
