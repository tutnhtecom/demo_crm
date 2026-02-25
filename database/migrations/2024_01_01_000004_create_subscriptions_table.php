<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique()->comment('Mã đăng ký');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('package_id')->constrained('packages')->onDelete('restrict');
            $table->foreignId('created_by')->nullable()->constrained('admin_users')->onDelete('set null');
            $table->enum('billing_cycle', ['monthly', 'yearly'])->default('monthly')->comment('Chu kỳ thanh toán');
            $table->decimal('price_at_subscription', 12, 2)->comment('Giá tại thời điểm đăng ký');
            $table->date('start_date')->comment('Ngày bắt đầu');
            $table->date('end_date')->comment('Ngày kết thúc');
            $table->date('next_billing_date')->comment('Ngày thanh toán tiếp theo');
            $table->enum('status', ['active', 'expired', 'suspended', 'cancelled', 'pending'])->default('pending')->comment('Trạng thái đăng ký');
            $table->boolean('auto_renew')->default(true)->comment('Tự động gia hạn');
            $table->text('cancel_reason')->nullable()->comment('Lý do hủy');
            $table->timestamp('cancelled_at')->nullable()->comment('Thời gian hủy');
            $table->foreignId('cancelled_by')->nullable()->constrained('admin_users')->onDelete('set null');
            $table->text('notes')->nullable()->comment('Ghi chú');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['customer_id', 'status']);
            $table->index(['package_id', 'status']);
            $table->index('next_billing_date');
            $table->index('end_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
