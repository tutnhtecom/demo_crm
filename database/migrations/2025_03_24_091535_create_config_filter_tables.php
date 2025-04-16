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
        if(!Schema::hasTable('config_filter')) {
            Schema::create('config_filter', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable(TRUE)->default(NULL)->comment('Lưu tên bộ lọc cần tìm kiêm, lọc');
                $table->date('start_date')->nullable(TRUE)->default(NULL)->comment('Lưu ngày bắt đầu cho bộ lọc');
                $table->date('end_date')->nullable(TRUE)->default(NULL)->comment('Lưu ngày kết thúc cho bộ lọc');
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
        Schema::dropIfExists('config_filter');
    }
};
