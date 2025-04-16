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
        Schema::create('academy_list_semesters', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(FALSE)->comment('Lưu tên học kỳ nhập học');
            $table->tinyInteger('academy_list_id')->nullable(FALSE)->comment('Lưu id khóa nhập học');
            $table->Integer('admission_year_id')->nullable(FALSE)->comment('Lưu id năm nhập học');
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('created_by')->nullable()->default(NULL)->comment('Lưu id người tạo mới');
            $table->bigInteger('updated_by')->nullable()->default(NULL)->comment('Lưu id người cập nhật');
            $table->bigInteger('deleted_by')->nullable()->default(NULL)->comment('Lưu id người xóa bỏ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academy_list_semesters');
    }
};
