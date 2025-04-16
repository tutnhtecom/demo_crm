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
        if (Schema::hasTable('files') && !Schema::hasColumn('file','types')) {
            Schema::table('files', function (Blueprint $table) {
                $table->tinyInteger('types')->nullable()->default(NULL)->after('id')->comment('Lưu kiểu file: 0: avatar, 1, Hồ sơ, 2: Tệp');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('files') && !Schema::hasColumn('file','types')) {
            Schema::table('files', function (Blueprint $table) {
                $table->tinyInteger('types')->nullable()->default(NULL)->after('id')->comment('Lưu kiểu file: 0: avatar, 1, Hồ sơ, 2: Tệp');
            });
        }
    }
};
