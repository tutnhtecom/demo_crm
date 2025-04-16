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
        if (Schema::hasTable('lst_status') && !Schema::hasColumn('lst_status','color')) {
            Schema::table('lst_status', function (Blueprint $table) {
                $table->string('color')->nullable()->default(NULL)->after('name')->comment('Lưu lại mã màu cho trạng thái');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('lst_status') && !Schema::hasColumn('lst_status','color')) {
            Schema::table('lst_status', function (Blueprint $table) {
                $table->string('color')->nullable()->default(NULL)->after('name')->comment('Lưu lại mã màu cho trạng thái');
            });
        }
    }
};
