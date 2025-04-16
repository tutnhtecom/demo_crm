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
        Schema::create('dvlk_students', function (Blueprint $table) {
            $table->id();
            $table->string('students_code', 150)->nullable(TRUE)->default(NULL)->comment('Lưu Mã số sinh viên');
            $table->string('students_name')->nullable(TRUE)->default(NULL)->comment('Lưu tên của sinh viên');            
            $table->string('students_status')->nullable(FALSE)->comment('Lưu trạng thái của sinh viên');
            $table->string('students_academy')->nullable(TRUE)->comment('Lưu khóa học của sinh viên');
            $table->string('students_majors')->nullable(TRUE)->comment('Lưu ngành học của sinh viên');
            $table->string('students_sources')->nullable(TRUE)->comment('Lưu đường dẫn ảnh của Thí sinh, sinh viên');
            $table->text('note')->nullable(TRUE)->comment('Lưu ghi chú của sinh viên');
            $table->bigInteger('created_by')->nullable(TRUE)->comment('Lưu id của người tạo');
            $table->bigInteger('updated_by')->nullable(TRUE)->comment('Lưu id của người cập nhật');
            $table->bigInteger('deleted_by')->nullable(TRUE)->comment('Lưu id của người xóa bỏ');
            $table->timestamps();
            $table->softDeletes();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dvlk_students');
    }
};
