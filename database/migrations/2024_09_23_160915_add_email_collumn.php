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
        if (Schema::hasTable('files') && !Schema::hasColumn('files', 'email')) {
            Schema::table('files', function (Blueprint $table) {
                $table->string('email', 255)->nullable()->default(NULL)->after('id')->comment('Lưu email của thí sinh trường hợp chưa đăng ký hồ sơ');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('files') && !Schema::hasColumn('files', 'email')) {
            Schema::table('files', function (Blueprint $table) {
                $table->string('email', 255)->nullable()->default(NULL)->after('id')->comment('Lưu email của thí sinh trường hợp chưa đăng ký hồ sơ');
            });
        }
    }
};
