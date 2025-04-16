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
        if(Schema::hasTable('roles_permissions')){
            if(!Schema::hasColumn('roles_permissions','created_at') && !Schema::hasColumn('roles_permissions','updated_at')) {
                Schema::table('roles_permissions', function (Blueprint $table) {                    
                    $table->timestamps();
                });
            }
            if(!Schema::hasColumn('roles_permissions','deleted_at')) {
                Schema::table('roles_permissions', function (Blueprint $table) {                    
                    $table->softDeletes();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('roles_permissions')){
            if(!Schema::hasColumn('roles_permissions','created_at') && !Schema::hasColumn('roles_permissions','updated_at')) {
                Schema::table('roles_permissions', function (Blueprint $table) {                    
                    $table->timestamps();
                });
            }
            if(!Schema::hasColumn('roles_permissions','deleted_at')) {
                Schema::table('roles_permissions', function (Blueprint $table) {                    
                    $table->softDeletes();
                });
            }
        }
    }
};
