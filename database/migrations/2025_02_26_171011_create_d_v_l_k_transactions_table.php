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
        Schema::create('dvlk_transactions', function (Blueprint $table) {
            $table->id();            
            $table->bigInteger('students_id')->nullable(TRUE)->default(NULL)->comment('Lưu Mã số sinh viên');
            $table->bigInteger('semesters_id')->nullable(TRUE)->default(NULL)->comment('Lưu mã học kỳ');            
            $table->string('tran_academy')->nullable(TRUE)->default(NULL)->comment('Lưu khóa học');            
            $table->string('tran_price')->nullable(TRUE)->default(NULL)->comment('Lưu học phí sinh viên đóng');                        
            $table->string('tran_debt')->nullable(TRUE)->default(NULL)->comment('Lưu tên của sinh viên');                        
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
        Schema::dropIfExists('dvlk_transactions');
    }
};
