<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->unique()->comment('Tên đăng nhập');
            $table->string('full_name', 100)->comment('Họ và tên');
            $table->string('email', 100)->unique()->comment('Email');
            $table->string('phone', 20)->nullable()->comment('Số điện thoại');
            $table->string('password')->comment('Mật khẩu (hashed)');
            $table->enum('role', ['super_admin', 'admin', 'operator', 'accountant'])->default('operator')->comment('Vai trò');
            $table->enum('status', ['active', 'inactive'])->default('active')->comment('Trạng thái');
            $table->timestamp('last_login_at')->nullable()->comment('Đăng nhập lần cuối');
            $table->string('last_login_ip', 45)->nullable()->comment('IP đăng nhập lần cuối');
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('role');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_users');
    }
};
