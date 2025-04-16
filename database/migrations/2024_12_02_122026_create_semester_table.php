<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('semesters', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false)->comment('Lưu tên học kỳ');
            $table->integer('from_day')->nullable()->default(NULL)->comment('Lưu ngày bắt đầu');
            $table->integer('from_month')->nullable()->default(NULL)->comment('Lưu tháng bắt đầu');
            $table->integer('from_year')->nullable()->default(NULL)->comment('Lưu năm bắt đầu');
            $table->integer('to_day')->nullable()->default(NULL)->comment('Lưu ngày kết thúc');
            $table->integer('to_month')->nullable()->default(NULL)->comment('Lưu tháng kết thúc');
            $table->integer('to_year')->nullable()->default(NULL)->comment('Lưu năm kết thúc');
            $table->bigInteger('created_by')->nullable(TRUE)->default(NULL)->comment('Lưu id người tạo');
            $table->bigInteger('updated_by')->nullable(TRUE)->default(NULL)->comment('Lưu id người sửa');
            $table->bigInteger('deleted_by')->nullable(TRUE)->default(NULL)->comment('Lưu id người xóa');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};
