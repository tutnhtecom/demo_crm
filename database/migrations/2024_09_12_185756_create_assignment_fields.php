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
        if (Schema::hasTable('leads')) {
            Schema::table('leads', function (Blueprint $table) {
                $table->bigInteger('assignments_id')->nullable()->default(NULL)->after('place_of_wrk_lrn')->comment('Lưu id của giao viên được phụ trách');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('leads')) {
            Schema::table('leads', function (Blueprint $table) {
                $table->bigInteger('assignments_id')->nullable()->default(NUll)->after('place_of_wrk_lrn')->comment('Lưu id của giao viên được phụ trách');
            });
        }
    }
};
