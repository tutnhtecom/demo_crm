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
        if (Schema::hasTable('leads') && Schema::hasColumn('leads','home_phone')) {
            Schema::table('leads', function (Blueprint $table) {
                $table->string('home_phone')->unique(false)->nullable()->default(NULL)->comment('Lưu số điện thoại nhà riêng')->change();                
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('leads') && Schema::hasColumn('leads','home_phone')) {
            Schema::table('leads', function (Blueprint $table) {
                $table->string('home_phone')->nullable()->default(NULL)->comment('Lưu số điện thoại nhà riêng')->change();                
            });
        }
    }
};
