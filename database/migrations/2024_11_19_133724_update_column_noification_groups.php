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
        if(Schema::hasTable('notifications_groups') && Schema::hasColumn('notifications_groups', 'email')) {
            Schema::table('notifications_groups', function (Blueprint $table) {
                // $table->renameColumn('email', 'list_id');
                $table->dropColumn('email');
            }); 
        }
        if(Schema::hasTable('notifications_groups') && !Schema::hasColumn('notifications_groups', 'list_id')) {
            Schema::table('notifications_groups', function($table) {
                $table->text('list_id')->nullable(TRUE)->default(NULL)->comment('Luu mang id cua sinh vien, nhan vien');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('notifications_groups') && Schema::hasColumn('notifications_groups', 'email')) {
            Schema::table('notifications_groups', function (Blueprint $table) {
                // $table->renameColumn('email', 'list_id');
                $table->dropColumn('email');
            }); 
        }
        if(Schema::hasTable('notifications_groups') && !Schema::hasColumn('notifications_groups', 'list_id')) {
            Schema::table('notifications_groups', function($table) {
                $table->text('list_id')->nullable(TRUE)->default(NULL)->comment('Luu mang id cua sinh vien, nhan vien');
            });
        }
    }
};
