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
        if (Schema::hasTable('transactions') && Schema::hasColumn('transactions', 'tran_status_id')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->bigInteger('tran_status_id')->unsigned()->nullable()->default(1)->comment('Lưu id trạng thái của giao dịch')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('transactions') && Schema::hasColumn('transactions', 'tran_status_id')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->bigInteger('tran_status_id')->unsigned()->nullable()->default(1)->comment('Lưu id trạng thái của giao dịch')->change();
            });
        }
    }
};
