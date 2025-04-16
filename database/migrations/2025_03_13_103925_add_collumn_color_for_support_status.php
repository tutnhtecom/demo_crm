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
        if(Schema::hasTable('supports_status')) {
            if(!Schema::hasColumn('supports_status', 'color')) {
                Schema::table('supports_status', function($table) {
                    $table->string('color')->nullable(TRUE)->default(NULL)->after('name')->comment('Lưu id của khóa');                
                });
            }
            if(!Schema::hasColumn('supports_status', 'bg_color')) {
                Schema::table('supports_status', function($table) {
                    $table->string('bg_color')->nullable(TRUE)->default(NULL)->after('color')->comment('Lưu id của khóa');                
                });
            }
            if(!Schema::hasColumn('supports_status', 'border_color')) {
                Schema::table('supports_status', function($table) {
                    $table->string('border_color')->nullable(TRUE)->default(NULL)->after('bg_color')->comment('Lưu id của khóa');                
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('supports_status')) {
            if(!Schema::hasColumn('supports_status', 'color')) {
                Schema::table('supports_status', function($table) {
                    $table->string('color')->nullable(TRUE)->default(NULL)->after('name')->comment('Lưu id của khóa');                
                });
            }
            if(!Schema::hasColumn('supports_status', 'bg_color')) {
                Schema::table('supports_status', function($table) {
                    $table->string('bg_color')->nullable(TRUE)->default(NULL)->after('color')->comment('Lưu id của khóa');                
                });
            }
            if(!Schema::hasColumn('supports_status', 'border_color')) {
                Schema::table('supports_status', function($table) {
                    $table->string('border_color')->nullable(TRUE)->default(NULL)->after('bg_color')->comment('Lưu id của khóa');                
                });
            }
        }
    }
};
