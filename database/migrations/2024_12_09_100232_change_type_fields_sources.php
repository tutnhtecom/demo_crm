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
        if (Schema::hasTable('sources') && Schema::hasColumn('sources', 'sources_manager_name')) {
            Schema::table('sources', function (Blueprint $table) {
                $table->text('sources_manager_name')->nullable()->default(NULL)->comment('Lưu thông tin lãnh đạo')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('sources') && Schema::hasColumn('sources', 'sources_manager_name')) {
            Schema::table('sources', function (Blueprint $table) {
                $table->text('sources_manager_name')->nullable()->default(NULL)->comment('Lưu thông tin lãnh đạo')->change();
            });
        }
    }
};
