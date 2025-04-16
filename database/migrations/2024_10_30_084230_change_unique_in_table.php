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
        //Employees
        if(Schema::hasTable('employees') && Schema::hasColumn('employees','email')){
            Schema::table('employees', function (Blueprint $table) {                    
                $table->string('email')->unique(false)->nullable(FALSE)->comment('Lưu email của người quản trị và sử dụng để đăng nhập hệ thống, không được phép trùng')->change();            
            });            
        }
        if(Schema::hasTable('employees') && Schema::hasColumn('employees','phone')){
            Schema::table('employees', function (Blueprint $table) {                    
                $table->string('phone')->unique(false)->nullable(TRUE)->comment('Lưu số điện thoại của Thí sinh, sinh viên')->change();            
            });            
        }
        if(Schema::hasTable('employees') && Schema::hasColumn('employees','code')){
            Schema::table('employees', function (Blueprint $table) {                    
                $table->string('code', 150)->unique(false)->nullable(TRUE)->default(NULL)->comment('Lưu mã hồ sơ')->change();
            });            
        }
        // Student
        if(Schema::hasTable('students') && Schema::hasColumn('students','email')){
            Schema::table('students', function (Blueprint $table) {                    
                $table->string('email')->unique(false)->nullable(FALSE)->comment('Lưu email của người quản trị và sử dụng để đăng nhập hệ thống, không được phép trùng')->change();            
            });            
        }
        if(Schema::hasTable('students') && Schema::hasColumn('students','phone')){
            Schema::table('students', function (Blueprint $table) {                    
                $table->string('phone')->unique(false)->nullable(TRUE)->comment('Lưu số điện thoại của Thí sinh, sinh viên')->change();            
            });            
        }
        if(Schema::hasTable('students') && Schema::hasColumn('students','code')){
            Schema::table('students', function (Blueprint $table) {                    
                $table->string('code', 150)->unique(false)->nullable(TRUE)->default(NULL)->comment('Lưu mã hồ sơ')->change();
            });            
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       //Employees
       if(Schema::hasTable('employees') && Schema::hasColumn('employees','email')){
        Schema::table('employees', function (Blueprint $table) {                    
            $table->string('email')->unique(false)->nullable(FALSE)->comment('Lưu email của người quản trị và sử dụng để đăng nhập hệ thống, không được phép trùng')->change();            
        });            
    }
    if(Schema::hasTable('employees') && Schema::hasColumn('employees','phone')){
        Schema::table('employees', function (Blueprint $table) {                    
            $table->string('phone')->unique(false)->nullable(TRUE)->comment('Lưu số điện thoại của Thí sinh, sinh viên')->change();            
        });            
    }
    if(Schema::hasTable('employees') && Schema::hasColumn('employees','code')){
        Schema::table('employees', function (Blueprint $table) {                    
            $table->string('code', 150)->unique(false)->nullable(TRUE)->default(NULL)->comment('Lưu mã hồ sơ')->change();
        });            
    }
    // Student
    if(Schema::hasTable('students') && Schema::hasColumn('students','email')){
        Schema::table('students', function (Blueprint $table) {                    
            $table->string('email')->unique(false)->nullable(FALSE)->comment('Lưu email của người quản trị và sử dụng để đăng nhập hệ thống, không được phép trùng')->change();            
        });            
    }
    if(Schema::hasTable('students') && Schema::hasColumn('students','phone')){
        Schema::table('students', function (Blueprint $table) {                    
            $table->string('phone')->unique(false)->nullable(TRUE)->comment('Lưu số điện thoại của Thí sinh, sinh viên')->change();            
        });            
    }
    if(Schema::hasTable('students') && Schema::hasColumn('students','code')){
        Schema::table('students', function (Blueprint $table) {                    
            $table->string('code', 150)->unique(false)->nullable(TRUE)->default(NULL)->comment('Lưu mã hồ sơ')->change();
        });            
    }
    }
};
