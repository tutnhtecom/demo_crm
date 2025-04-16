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
        if (Schema::hasTable('supports') && Schema::hasColumn('supports', 'file_url')) {
            Schema::table('supports', function (Blueprint $table) {                
                $table->text('file_url')->nullable(TRUE)->default(NULL)->comment('Luu lai duong dan file')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('supports') && Schema::hasColumn('supports', 'file_url')) {
            Schema::table('supports', function (Blueprint $table) {                
                $table->text('file_url')->nullable(TRUE)->default(NULL)->comment('Luu lai duong dan file')->change();
            });
        }
    }
};
