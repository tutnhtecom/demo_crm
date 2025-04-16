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
        if (Schema::hasTable('employees') && !Schema::hasColumn('employees','roles_id')) {
            Schema::table('employees', function (Blueprint $table) {
                $table->bigInteger('roles_id')->unsigned()->after('status')->nullable()->default(3)->comment('Lưu id của vai trò nhân viên');
                $table->foreign('roles_id')->references('id')->on('roles')->onDelete('cascade');       
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('employees') && !Schema::hasColumn('employees','roles_id')) {
            Schema::table('employees', function (Blueprint $table) {
                $table->bigInteger('roles_id')->unsigned()->after('status')->nullable()->default(3)->comment('Lưu id của vai trò nhân viên');
                $table->foreign('roles_id')->references('id')->on('roles')->onDelete('cascade');       
            });
        }
    }
};
