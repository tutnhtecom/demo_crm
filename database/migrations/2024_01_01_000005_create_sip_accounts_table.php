<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sip_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('subscription_id')->nullable()->constrained('subscriptions')->onDelete('set null');
            $table->string('sip_username', 50)->unique()->comment('SIP Username');
            $table->string('sip_password', 100)->comment('SIP Password (encrypted)');
            $table->string('sip_domain', 100)->comment('SIP Domain/Server');
            $table->string('display_name', 100)->nullable()->comment('Tên hiển thị');
            $table->string('extension', 20)->nullable()->comment('Số máy nhánh');
            $table->string('did_number', 20)->nullable()->unique()->comment('Số DID');
            $table->string('caller_id', 50)->nullable()->comment('Caller ID');
            $table->enum('status', ['active', 'suspended', 'terminated'])->default('active')->comment('Trạng thái SIP');
            $table->enum('registration_status', ['registered', 'unregistered', 'unknown'])->default('unknown')->comment('Trạng thái đăng ký SIP');
            $table->string('last_registered_ip', 45)->nullable()->comment('IP đăng ký lần cuối');
            $table->timestamp('last_registered_at')->nullable()->comment('Thời gian đăng ký lần cuối');
            $table->text('notes')->nullable()->comment('Ghi chú');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['customer_id', 'status']);
            $table->index('registration_status');
            $table->index('did_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sip_accounts');
    }
};
