<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('call_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sip_account_id')->constrained('sip_accounts')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('call_id', 100)->nullable()->comment('SIP Call-ID');
            $table->string('caller_number', 30)->comment('Số gọi đi');
            $table->string('callee_number', 30)->comment('Số gọi đến');
            $table->enum('direction', ['inbound', 'outbound'])->comment('Chiều cuộc gọi');
            $table->enum('call_type', ['domestic', 'international', 'internal'])->default('domestic')->comment('Loại cuộc gọi');
            $table->enum('status', ['answered', 'no_answer', 'busy', 'failed'])->comment('Trạng thái cuộc gọi');
            $table->timestamp('started_at')->comment('Thời gian bắt đầu');
            $table->timestamp('answered_at')->nullable()->comment('Thời gian kết nối');
            $table->timestamp('ended_at')->nullable()->comment('Thời gian kết thúc');
            $table->integer('duration_seconds')->default(0)->comment('Thời lượng (giây)');
            $table->decimal('charge_amount', 10, 2)->default(0)->comment('Cước phí');
            $table->string('recording_path', 255)->nullable()->comment('Đường dẫn file ghi âm');
            $table->timestamps();

            $table->index(['customer_id', 'started_at']);
            $table->index(['sip_account_id', 'started_at']);
            $table->index('call_type');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('call_logs');
    }
};
