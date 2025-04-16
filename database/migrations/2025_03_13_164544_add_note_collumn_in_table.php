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
        if(Schema::hasTable('supports')) {
            if(!Schema::hasColumn('supports', 'note')) {
                Schema::table('supports', function($table) {
                    $table->text('note')->nullable(TRUE)->default(NULL)->after('sp_status_id')->comment('Lưu ghi chú cho Yêu cầu hỗ trợ');
                });
            }           
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('supports')) {
            if(!Schema::hasColumn('supports', 'note')) {
                Schema::table('supports', function($table) {
                    $table->text('note')->nullable(TRUE)->default(NULL)->after('sp_status_id')->comment('Lưu ghi chú cho Yêu cầu hỗ trợ');
                });
            }           
        }
    }
};
