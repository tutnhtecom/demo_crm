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
        Schema::create('dvlk_semesters', function (Blueprint $table) {
            $table->id();            
            $table->string('semesters_name')->nullable(TRUE)->default(NULL)->comment('Lưu tên của học kỳ');            
            $table->integer('semesters_from_year')->nullable(TRUE)->default(NULL)->comment('Lưu năm bắt đầu kỳ');            
            $table->integer('semesters_to_year')->nullable(TRUE)->default(NULL)->comment('Lưu năm kết thúc');            
            $table->string('semesters_full_year')->nullable(TRUE)->default(NULL)->comment('Lưu tên của sinh viên');                        
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
        Schema::dropIfExists('dvlk_semesters');
    }
};
