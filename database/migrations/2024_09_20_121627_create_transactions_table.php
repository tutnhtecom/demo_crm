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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('code')->unique()->nullable(FALSE)->comment('Lưu mã của giao dịch');
            $table->string('name', 255)->nullable(FALSE)->comment('Lưu tên giao dịch');
            $table->bigInteger('leads_id')->unsigned()->nullable(FALSE)->comment('Lưu id của thí sinh');
            $table->bigInteger('tran_status_id')->unsigned()->nullable(FALSE)->comment('Lưu nội dung của ghi chú');
            $table->bigInteger('tran_types_id')->unsigned()->nullable(FALSE)->comment('Lưu id của bảng loại doanh thu');
            $table->bigInteger('price_lists_id')->unsigned()->nullable(FALSE)->comment('Lưu id của bảng giá');
            $table->double('price')->nullable(FALSE)->comment('Lưu giá trị giao dịch (VNĐ)');
            $table->bigInteger('academic_terms_id')->unsigned()->nullable(FALSE)->comment('Lưu id của niên khoá');
            $table->bigInteger('semesters_id')->unsigned()->nullable(FALSE)->comment('Lưu id của học kì');
            $table->date('tran_date')->nullable(FALSE)->comment('Lưu ngày giao dịch');
            $table->time('tran_time')->nullable(FALSE)->comment('Lưu thời gian giao dịch');
            $table->text('note')->nullable()->default(NULL)->comment('Lưu nội dung của ghi chú');
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('created_by')->nullable()->default(NULL)->comment('Lưu id người tạo mới');
            $table->bigInteger('updated_by')->nullable()->default(NULL)->comment('Lưu id người cập nhật');
            $table->bigInteger('deleted_by')->nullable()->default(NULL)->comment('Lưu id người xóa bỏ');

            $table->foreign('leads_id')->references('id')->on('leads')->onDelete('cascade');
            $table->foreign('tran_status_id')->references('id')->on('transactions_status')->onDelete('cascade');
            $table->foreign('tran_types_id')->references('id')->on('transactions_types')->onDelete('cascade');
            $table->foreign('price_lists_id')->references('id')->on('price_lists')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
