<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 30)->unique()->comment('Số hóa đơn');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('restrict');
            $table->foreignId('subscription_id')->nullable()->constrained('subscriptions')->onDelete('set null');
            $table->enum('type', ['subscription', 'usage', 'adjustment', 'refund'])->default('subscription')->comment('Loại hóa đơn');
            $table->decimal('subtotal', 15, 2)->default(0)->comment('Tiền trước thuế');
            $table->decimal('tax_rate', 5, 2)->default(10)->comment('Thuế suất (%)');
            $table->decimal('tax_amount', 15, 2)->default(0)->comment('Tiền thuế');
            $table->decimal('discount_amount', 15, 2)->default(0)->comment('Tiền giảm giá');
            $table->decimal('total_amount', 15, 2)->comment('Tổng tiền thanh toán');
            $table->enum('status', ['draft', 'issued', 'paid', 'partially_paid', 'overdue', 'cancelled'])->default('draft')->comment('Trạng thái');
            $table->decimal('paid_amount', 15, 2)->default(0)->comment('Số tiền đã thanh toán');
            $table->date('issue_date')->comment('Ngày phát hành');
            $table->date('due_date')->comment('Hạn thanh toán');
            $table->date('paid_date')->nullable()->comment('Ngày thanh toán');
            $table->date('period_from')->nullable()->comment('Kỳ từ ngày');
            $table->date('period_to')->nullable()->comment('Kỳ đến ngày');
            $table->text('notes')->nullable()->comment('Ghi chú');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['customer_id', 'status']);
            $table->index('due_date');
            $table->index('issue_date');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
