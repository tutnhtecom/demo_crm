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
        if (Schema::hasTable('price_lists') && Schema::hasColumn('price_lists', 'code')) {
            Schema::table('price_lists', function (Blueprint $table) {
                $table->string('code')->nullable()->default(NULL)->comment('Lưu id trạng thái của giao dịch')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('price_lists') && Schema::hasColumn('price_lists', 'code')) {
            Schema::table('price_lists', function (Blueprint $table) {
                $table->string('code')->nullable()->default(NULL)->comment('Lưu id trạng thái của giao dịch')->change();
            });
        }
    }
};
