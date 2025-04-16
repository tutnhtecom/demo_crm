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
        if(Schema::hasTable('source_price_lists') && !Schema::hasColumn('source_price_lists', 'status')) {
            Schema::table('source_price_lists', function($table) {
                $table->string('tran_status')->nullable(TRUE)->default(NULL)->after('note')->comment('Lưu trạng thái của giao dịch');                
            });
        }        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('source_price_lists') && !Schema::hasColumn('source_price_lists', 'status')) {
            Schema::table('source_price_lists', function($table) {
                $table->string('tran_status')->nullable(TRUE)->default(null)->before('note')->comment('Lưu trạng thái của giao dịch');                
            });
        }
    }
};
