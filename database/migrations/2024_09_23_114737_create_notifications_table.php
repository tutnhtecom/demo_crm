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
        if (!Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->id();
                $table->string('email',255)->nullable(FALSE)->comment('Lưu email nhận thông báo');
                $table->string('title', 150)->nullable(FALSE)->comment('Lưu tiêu đề thông báo');
                $table->text('content')->nullable(FALSE)->comment('Lưu nội dung thông báo');
                $table->tinyInteger('obj_types')->nullable(FALSE)->comment('Lưu kiểu đối tượng: 0: Thí sinh mới, 1: Sinh viên, 2: Nhân viên');
                $table->tinyInteger('send_types')->nullable(FALSE)->comment('Lưu kiểu thông báo: 0: Gửi cả email, thông báo trên hệ thống, 1: Chỉ gửi email, 2: Chỉ thông báo trên hệ thống');
                $table->smallInteger('status')->nullable(TRUE)->default(0)->comment('Lưu kiểu đối tượng: 0: Bản nháp, 1: Đã gửi');
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
        Schema::dropIfExists('notifications');
    }
};
