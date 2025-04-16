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
        if(Schema::hasTable('supports') && !Schema::hasColumn('supports', 'file_url')) {
            Schema::table('supports', function($table) {
                $table->text('file_url')->nullable(TRUE)->default(null)->after('sp_status_id')->comment('Luu muc doc uu tien: 0: thap, 1: cao');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('supports') && !Schema::hasColumn('supports', 'file_url')) {
            Schema::table('supports', function($table) {
                $table->text('file_url')->nullable(TRUE)->default(NULL)->after('sp_status_id')->comment('Luu muc doc uu tien: 0: thap, 1: cao');
            });
        }
    }
};
