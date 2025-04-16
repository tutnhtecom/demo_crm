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
        if (Schema::hasTable('notifications') && !Schema::hasColumn('notifications','topic')) {
            Schema::table('notifications', function (Blueprint $table) {
                $table->string('topic')->nullable()->after('email')->default(NULL)->comment('Lưu chủ đề của thông báo');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('notifications') && !Schema::hasColumn('notifications','topic')) {
            Schema::table('notifications', function (Blueprint $table) {
                $table->string('topic')->nullable()->after('email')->default(NULL)->comment('Lưu chủ đề của thông báo');
            });
        }
    }
};
