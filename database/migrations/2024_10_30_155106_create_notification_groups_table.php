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
        if(!Schema::hasTable('notifications_groups')) {
            Schema::create('notifications_groups', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable(FALSE)->default(NULL)->comment('Lưu tên nhóm gửi thông báo');
                $table->text('email')->nullable(TRUE)->default(NULL)->comment('Lưu email nhận thông báo');
                $table->timestamps();
                $table->softDeletes();
                $table->bigInteger('created_by')->nullable()->default(NULL)->comment('Lưu id người tạo mới');
                $table->bigInteger('updated_by')->nullable()->default(NULL)->comment('Lưu id người cập nhật');
                $table->bigInteger('deleted_by')->nullable()->default(NULL)->comment('Lưu id người xóa bỏ');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications_groups');
    }
};
