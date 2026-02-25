<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action', 100)->comment('Hành động thực hiện');
            $table->string('module', 50)->comment('Module liên quan');
            $table->enum('actor_type', ['admin', 'customer', 'system'])->comment('Loại tác nhân');
            $table->unsignedBigInteger('actor_id')->nullable()->comment('ID tác nhân');
            $table->string('actor_name', 100)->nullable()->comment('Tên tác nhân');
            $table->string('ip_address', 45)->nullable()->comment('Địa chỉ IP');
            $table->nullableMorphs('subject'); // subject_type, subject_id - đối tượng bị tác động
            $table->json('old_values')->nullable()->comment('Giá trị cũ');
            $table->json('new_values')->nullable()->comment('Giá trị mới');
            $table->text('description')->nullable()->comment('Mô tả chi tiết');
            $table->enum('level', ['info', 'warning', 'error', 'critical'])->default('info')->comment('Mức độ');
            $table->timestamp('created_at')->useCurrent();

            $table->index(['actor_type', 'actor_id']);
            $table->index(['module', 'action']);
            $table->index('level');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_logs');
    }
};
