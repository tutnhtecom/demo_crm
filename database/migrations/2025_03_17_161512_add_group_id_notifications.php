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
        if(Schema::hasTable('notifications') && !Schema::hasColumn('notifications', 'obj_create')) {
            Schema::table('notifications', function($table) {
                $table->tinyInteger('obj_create')->nullable(TRUE)->default(0)->after('send_types')->comment('Lưu nguồn thêm từ đâu: 0: leads, 1: students, 2: employees');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('notifications') && !Schema::hasColumn('notifications', 'obj_create')) {
            Schema::table('notifications', function($table) {
                $table->tinyInteger('obj_create')->nullable(TRUE)->default(0)->after('send_types')->comment('Lưu nguồn thêm từ đâu: 0: leads, 1: students, 2: employees');
            });
        }
    }
};
