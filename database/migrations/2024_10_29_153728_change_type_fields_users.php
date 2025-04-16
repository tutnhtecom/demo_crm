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
        if(Schema::hasTable('users') && Schema::hasColumn('users','email')){
            Schema::table('users', function (Blueprint $table) {                    
                $table->string('email')->unique(false)->nullable(FALSE)->comment('Lưu email của người quản trị và sử dụng để đăng nhập hệ thống, không được phép trùng')->change();            
            });            
        }
        if(Schema::hasTable('leads') && Schema::hasColumn('leads','email')){
            Schema::table('leads', function (Blueprint $table) {                    
                $table->string('email')->unique(false)->nullable(FALSE)->comment('Lưu email của người quản trị và sử dụng để đăng nhập hệ thống, không được phép trùng')->change();            
            });            
        }
        if(Schema::hasTable('leads') && Schema::hasColumn('leads','phone')){
            Schema::table('leads', function (Blueprint $table) {                    
                $table->string('phone')->unique(false)->nullable(TRUE)->comment('Lưu số điện thoại của Thí sinh, sinh viên')->change();            
            });            
        }
        if(Schema::hasTable('leads') && Schema::hasColumn('leads','code')){
            Schema::table('leads', function (Blueprint $table) {                    
                $table->string('code', 150)->unique(false)->nullable(TRUE)->default(NULL)->comment('Lưu mã hồ sơ')->change();
            });            
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('users') && Schema::hasColumn('users','email')){
            Schema::table('users', function (Blueprint $table) {                    
                $table->string('email')->unique(false)->nullable(FALSE)->comment('Lưu email của người quản trị và sử dụng để đăng nhập hệ thống, không được phép trùng')->change();            
            });            
        }
        if(Schema::hasTable('leads') && Schema::hasColumn('leads','email')){
            Schema::table('leads', function (Blueprint $table) {                    
                $table->string('email')->unique(false)->nullable(FALSE)->comment('Lưu email của người quản trị và sử dụng để đăng nhập hệ thống, không được phép trùng')->change();            
            });            
        }
        if(Schema::hasTable('leads') && Schema::hasColumn('leads','phone')){
            Schema::table('leads', function (Blueprint $table) {                    
                $table->string('phone')->unique(false)->nullable(TRUE)->comment('Lưu số điện thoại của Thí sinh, sinh viên')->change();            
            });            
        }
        if(Schema::hasTable('leads') && Schema::hasColumn('leads','code')){
            Schema::table('leads', function (Blueprint $table) {                    
                $table->string('code', 150)->unique(false)->nullable(TRUE)->default(NULL)->comment('Lưu mã hồ sơ')->change();            
            });            
        }
    }
};
