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
        if(!Schema::hasTable('academic_terms'))     {
            Schema::create('academic_terms', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable(FALSE)->comment('Lưu tên của niên khóa');           
                $table->integer('from_year')->nullable(TRUE)->default(NULL)->comment('Năm bắt đầu niên khóa');
                $table->integer('to_year')->nullable(TRUE)->default(NULL)->comment('Năm kết thúc niên khóa');
                $table->string('note')->nullable(TRUE)->default(NULL)->comment('Lưu mô tả của niên khóa');           
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
        Schema::dropIfExists('academic_terms');
    }
};
