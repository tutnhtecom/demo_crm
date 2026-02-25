<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique()->comment('Mã khách hàng');
            $table->string('full_name', 100)->comment('Họ và tên');
            $table->string('email', 100)->unique()->comment('Email');
            $table->string('phone', 20)->unique()->comment('Số điện thoại');
            $table->string('id_card', 20)->nullable()->comment('Số CMND/CCCD');
            $table->string('address', 255)->nullable()->comment('Địa chỉ');
            $table->string('province', 100)->nullable()->comment('Tỉnh/Thành phố');
            $table->enum('customer_type', ['individual', 'business'])->default('individual')->comment('Loại khách hàng');
            $table->string('company_name', 150)->nullable()->comment('Tên công ty (nếu doanh nghiệp)');
            $table->string('tax_code', 20)->nullable()->comment('Mã số thuế');
            $table->decimal('balance', 15, 2)->default(0)->comment('Số dư tài khoản');
            $table->enum('status', ['active', 'inactive', 'locked'])->default('active')->comment('Trạng thái');
            $table->string('password')->comment('Mật khẩu (hashed)');
            $table->string('remember_token', 100)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'customer_type']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
