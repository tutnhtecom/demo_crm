<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code', 50)->unique()->comment('Mã giao dịch');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('restrict');
            $table->foreignId('invoice_id')->nullable()->constrained('invoices')->onDelete('set null');
            $table->decimal('amount', 15, 2)->comment('Số tiền thanh toán');
            $table->enum('payment_method', ['bank_transfer', 'credit_card', 'e_wallet', 'cash', 'vnpay', 'momo', 'zalopay'])->comment('Phương thức thanh toán');
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded', 'cancelled'])->default('pending')->comment('Trạng thái');
            $table->string('gateway_transaction_id', 100)->nullable()->comment('Mã giao dịch cổng thanh toán');
            $table->json('gateway_response')->nullable()->comment('Phản hồi cổng thanh toán');
            $table->text('description')->nullable()->comment('Mô tả');
            $table->timestamp('paid_at')->nullable()->comment('Thời gian thanh toán');
            $table->foreignId('confirmed_by')->nullable()->constrained('admin_users')->onDelete('set null');
            $table->timestamp('confirmed_at')->nullable()->comment('Thời gian xác nhận');
            $table->timestamps();

            $table->index(['customer_id', 'status']);
            $table->index(['invoice_id', 'status']);
            $table->index('paid_at');
            $table->index('payment_method');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
