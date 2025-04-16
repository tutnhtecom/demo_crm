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
        if(Schema::hasTable('employees') && Schema::hasColumn('employees', 'avatar')) {
            Schema::table('employees', function($table) {
                $table->dropColumn('avatar');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('employees') && Schema::hasColumn('employees', 'avatar')) {
            Schema::table('employees', function($table) {
                $table->dropColumn('avatar');
            });
        }
    }
};
