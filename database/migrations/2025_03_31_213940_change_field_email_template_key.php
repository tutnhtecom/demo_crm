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
        if (Schema::hasTable('email_template_key') && Schema::hasColumn('email_template_key', 'types')) {
            Schema::table('email_template_key', function (Blueprint $table) {
               $table->dropColumn('types');
            });
        }
        if (Schema::hasTable('email_template_key') && !Schema::hasColumn('email_template_key', 'email_template_types_id')) {
            Schema::table('email_template_key', function (Blueprint $table) {
                $table->bigInteger('email_template_types_id')->nullable(TRUE)->default(Null)->comment('Luu id cua kieu mau email');     
            });
        }
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('email_template_key') && Schema::hasColumn('email_template_key', 'types')) {
            Schema::table('email_template_key', function (Blueprint $table) {
               $table->dropColumn('types');
            });
        }
        if (Schema::hasTable('email_template_key') && !Schema::hasColumn('email_template_key', 'email_template_types_id')) {
            Schema::table('email_template_key', function (Blueprint $table) {
                $table->bigInteger('email_template_types_id')->nullable(TRUE)->default(Null)->comment('Luu id cua kieu mau email');     
            });
        }
    }
};
