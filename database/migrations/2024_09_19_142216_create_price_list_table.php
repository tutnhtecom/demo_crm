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
        Schema::create('price_lists', function (Blueprint $table) {
            $table->id();      
            $table->bigInteger('leads_id')->unsigned()->nullable(FALSE)->comment('Lưu mã bảng giá');      
            $table->integer('code')->nullable(FALSE)->comment('Lưu mã bảng giá');
            $table->string('title', 255)->nullable(FALSE)->comment('Lưu nội dung của tiêu đề');
            $table->double('price',2)->nullable(FALSE)->comment('Lưu số tiền học phí (đơn vị: VNĐ)');
            $table->date('from_date')->nullable(FALSE)->comment('Lưu hạn nộp từ ngày');
            $table->date('to_date')->nullable(FALSE)->comment('Lưu hạn nộp đến ngày');
            $table->text('note')->nullable()->default(NULL)->comment('Lưu nội dung của ghi chú');
            $table->smallInteger('status')->nullable()->default(0)->comment('Lưu nội dung của ghi chú');
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('created_by')->nullable()->default(NULL)->comment('Lưu id người tạo mới');
            $table->bigInteger('updated_by')->nullable()->default(NULL)->comment('Lưu id người cập nhật');
            $table->bigInteger('deleted_by')->nullable()->default(NULL)->comment('Lưu id người xóa bỏ');

            $table->foreign('leads_id')->references('id')->on('leads')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_lists');
    }
};
