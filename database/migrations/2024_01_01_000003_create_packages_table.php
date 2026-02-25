<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique()->comment('Mã gói cước');
            $table->string('name', 100)->comment('Tên gói cước');
            $table->text('description')->nullable()->comment('Mô tả');
            $table->enum('type', ['basic', 'standard', 'premium', 'enterprise'])->default('basic')->comment('Loại gói');
            $table->decimal('price_monthly', 12, 2)->comment('Giá theo tháng (VNĐ)');
            $table->decimal('price_yearly', 12, 2)->nullable()->comment('Giá theo năm (VNĐ)');
            $table->integer('sip_account_limit')->default(1)->comment('Số tài khoản SIP tối đa');
            $table->integer('concurrent_call_limit')->default(1)->comment('Số cuộc gọi đồng thời tối đa');
            $table->integer('free_minutes_domestic')->default(0)->comment('Phút gọi nội địa miễn phí/tháng');
            $table->integer('free_minutes_international')->default(0)->comment('Phút gọi quốc tế miễn phí/tháng');
            $table->decimal('rate_per_minute_domestic', 8, 2)->default(0)->comment('Giá/phút gọi nội địa vượt mức');
            $table->decimal('rate_per_minute_international', 8, 2)->default(0)->comment('Giá/phút gọi quốc tế vượt mức');
            $table->integer('storage_gb')->default(0)->comment('Dung lượng lưu trữ voicemail (GB)');
            $table->json('features')->nullable()->comment('Các tính năng bổ sung (JSON)');
            $table->enum('status', ['active', 'inactive', 'discontinued'])->default('active')->comment('Trạng thái');
            $table->integer('sort_order')->default(0)->comment('Thứ tự hiển thị');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'type']);
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
